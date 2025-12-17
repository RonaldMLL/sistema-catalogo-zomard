<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Provider;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // 1. Mostrar historial de compras
    public function index()
    {
        $purchases = Purchase::with(['provider', 'product'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    // 2. Formulario de nueva compra
    public function create()
    {
        $providers = Provider::all();
        $products = Product::all(); // Aquí cargarás tus inodoros
        return view('purchases.create', compact('providers', 'products'));
    }

    // 3. GUARDAR Y SUMAR STOCK (La parte importante)
    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        // A. Guardar el registro de la compra
        Purchase::create($request->all());

        // B. ACTUALIZAR EL STOCK DEL PRODUCTO
        $product = Product::findOrFail($request->product_id);
        
        // increment() es una función mágica de Laravel que suma al valor actual
        $product->increment('stock', $request->quantity);

        return redirect()->route('purchases.index')
            ->with('success', '¡Compra registrada! El stock ha sido actualizado.');
    }
}