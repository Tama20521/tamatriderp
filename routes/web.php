<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (todos)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ventas (todos)
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store']);

    // Productos (listar todos)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Clientes (todos)
    Route::resource('clients', ClientController::class);

    // Solo ADMIN
    Route::middleware('admin')->group(function () {
        // Productos: CRUD completo
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Gestión de usuarios
        Route::resource('users', UserController::class)->except(['show']);

        // Gestión de proveedores
        Route::resource('suppliers', SupplierController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';