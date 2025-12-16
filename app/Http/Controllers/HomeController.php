<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Client;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Cálculos de Dinero
        $totalVendido = Sale::sum('total'); // Todo lo facturado
        $dineroEnCaja = Sale::where('status', 'pagado')->sum('total'); // Lo que ya cobraste
        $porCobrar    = Sale::where('status', 'pendiente')->sum('total'); // Lo que te deben (Fiado)
        
        // 2. Contadores
        $totalClientes = Client::count();
        $totalProductos = Product::count();
        
        // 3. Alertas de Stock Bajo (Menos de 5 unidades)
        $productosBajos = Product::where('stock', '<=', 5)->get();

        // 4. Últimas 5 ventas (para acceso rápido)
        $ultimasVentas = Sale::with('client')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalVendido', 
            'dineroEnCaja', 
            'porCobrar', 
            'totalClientes', 
            'totalProductos',
            'productosBajos',
            'ultimasVentas'
        ));
    }
}