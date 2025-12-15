<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController; // <--- CLIENTES
use App\Http\Controllers\SaleController; // <--- VENTAS
Route::get('/', function () {
    return view('welcome');
});

// Ruta para ver el formulario
Route::get('/crear-producto', [ProductController::class, 'create'])->name('products.create');

// Ruta para recibir los datos (POST)
Route::post('/productos', [ProductController::class, 'store'])->name('products.store');

// Ruta para ver el catálogo público
Route::get('/catalogo', [ProductController::class, 'index'])->name('products.index');

// Ruta para ver el formulario de edición
Route::get('/productos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');

// Ruta para guardar los cambios (PUT)
Route::put('/productos/{product}', [ProductController::class, 'update'])->name('products.update');

Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// ... PDF Download Route

Route::get('/descargar-catalogo', [ProductController::class, 'downloadPdf'])->name('products.pdf');


// RUTAS DE CLIENTES
Route::get('/clientes', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clientes/crear', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clientes', [ClientController::class, 'store'])->name('clients.store');

// RUTAS DE VENTAS
Route::get('/ventas', [SaleController::class, 'index'])->name('sales.index'); // <--- NUEVA
Route::get('/nueva-venta', [SaleController::class, 'create'])->name('sales.create');
Route::get('/ventas/{id}', [SaleController::class, 'show'])->name('sales.show');
Route::post('/guardar-venta', [SaleController::class, 'store'])->name('sales.store');