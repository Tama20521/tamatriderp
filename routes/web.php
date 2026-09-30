<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ventas y Cuentas por Cobrar
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store']);
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/sale/{sale}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/sale/{sale}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/sale/{sale}', [PaymentController::class, 'store'])->name('payments.store');

    // Clientes
    Route::resource('clients', ClientController::class);

    // Productos (listar)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Solo ADMIN
    Route::middleware('admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('suppliers', SupplierController::class);

        // Compras
        Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);

        // Cuentas por Pagar
        Route::get('/supplier-payments', [SupplierPaymentController::class, 'index'])->name('supplier_payments.index');
        Route::get('/supplier-payments/purchase/{purchase}', [SupplierPaymentController::class, 'show'])->name('supplier_payments.show');
        Route::get('/supplier-payments/purchase/{purchase}/create', [SupplierPaymentController::class, 'create'])->name('supplier_payments.create');
        Route::post('/supplier-payments/purchase/{purchase}', [SupplierPaymentController::class, 'store'])->name('supplier_payments.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';