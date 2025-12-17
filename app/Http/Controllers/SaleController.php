<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para transacciones seguras

class SaleController extends Controller
{
    // 1. Mostrar la pantalla de "Nueva Venta"
    public function create()
    {
        // Necesitamos clientes y productos para llenar los selectores
        $clients = Client::all();
        // Solo traemos productos que tengan stock positivo > 0
        $products = Product::where('stock', '>', 0)->get();
        
        return view('sales.create', compact('clients', 'products'));
    }

    // 2. Guardar la venta completa
    public function store(Request $request)
    {
        // Validamos
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'products' => 'required|array', // Esperamos una lista de productos
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Usamos DB::transaction para que si algo falla, NO se guarde nada a medias
        DB::transaction(function () use ($request) {
            
            // A. Calcular Total y Crear la Cabecera de Venta
            $total = 0;
            // (Nota: Podríamos calcular el total sumando el JS, pero por seguridad lo recalculamos aquí)
            
            $sale = Sale::create([
                'client_id' => $request->client_id,
                'sale_date' => now(),
                'status' => 'pendiente', // Por defecto pendiente de cobro completo
                'total' => 0 // Lo actualizaremos al final
            ]);

            // B. Recorrer los productos del carrito
            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                
                // Verificar si hay stock suficiente (Doble seguridad)
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("No hay suficiente stock de " . $product->name);
                }

                // 1. Crear el Detalle
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price, // Usamos el precio actual del producto
                ]);

                // 2. Descontar del Inventario (IMPORTANTE)
                $product->decrement('stock', $item['quantity']);

                // 3. Sumar al total
                $total += $product->price * $item['quantity'];
            }

            // C. Actualizar el total final de la venta
            $sale->update(['total' => $total]);
        });

        return redirect()->route('products.index')->with('success', '¡Venta registrada y stock actualizado!');
    }
    public function index()
    {
        // Traemos las ventas con la info del cliente, ordenadas de la más nueva a la más vieja
        $sales = Sale::with('client')->latest()->paginate(10);
        
        return view('sales.index', compact('sales'));
    }
    public function show($id)
    {
        // Buscamos la venta y cargamos 'details' (los items) y 'product' (para saber el nombre)
        $sale = Sale::with(['client', 'details.product'])->findOrFail($id);
        
        return view('sales.show', compact('sale'));
    }
    // 4. Registrar un ABONO (Pago parcial)
    public function addPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.1',
            'payment_date' => 'required|date'
        ]);

        $sale = Sale::findOrFail($id);

        // Validar que no pague más de lo que debe
        if ($request->amount > $sale->due_amount) {
            return back()->withErrors(['amount' => 'El monto excede la deuda actual (Bs ' . $sale->due_amount . ')']);
        }

        // 1. Crear el pago
        $sale->payments()->create([
            'amount' => $request->amount,
            'payment_date' => $request->payment_date
        ]);

        // 2. Verificar si ya pagó todo para cambiar el estado
        // Recalculamos el saldo restando el nuevo pago
        if ($sale->refresh()->due_amount <= 0) {
            $sale->update(['status' => 'pagado']);
        } else {
            // Si aun debe, nos aseguramos que diga 'pendiente'
            $sale->update(['status' => 'pendiente']);
        }

        return back()->with('success', '¡Abono registrado correctamente!');
    }
}