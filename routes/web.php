<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

// ...

Route::get('/descargar-catalogo', [ProductController::class, 'downloadPdf'])->name('products.pdf');