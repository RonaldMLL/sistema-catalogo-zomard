<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Cualquiera las ve)
|--------------------------------------------------------------------------
*/

// Redirigir la raíz al Login si no ha entrado, o al Dashboard si ya entró
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Solo usuarios logueados - EL CANDADO 🔒)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD (Página Principal)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // 2. PRODUCTOS
    Route::get('/productos/pdf', [ProductController::class, 'downloadPdf'])->name('products.pdf'); // <--- ¡AGREGA ESTA LÍNEA!
    Route::resource('products', ProductController::class);

    // 3. CLIENTES
    // Rutas manuales que creamos
    Route::get('/clientes', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clientes/crear', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clientes', [ClientController::class, 'store'])->name('clients.store');

    // 4. VENTAS
    Route::get('/ventas', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/ventas/{id}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/nueva-venta', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/guardar-venta', [SaleController::class, 'store'])->name('sales.store');
    
    // Pagos / Abonos
    Route::post('/ventas/{id}/abono', [SaleController::class, 'addPayment'])->name('sales.add_payment'); // <--- TU NUEVA RUTA DE ABONOS

    // PERFIL DE USUARIO (Viene con Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación (Login, Registro, etc.) generadas por Breeze
require __DIR__.'/auth.php';
