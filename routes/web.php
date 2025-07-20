<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard protegido
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rutas para productos (solo para artesanos)
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
});

// Catálogo público de productos
Route::get('catalogo', [ProductController::class, 'catalogo'])->name('catalogo');
Route::get('catalogo/{product}', [ProductController::class, 'show'])->name('catalogo.show');

// Carrito de compras (solo clientes autenticados)
Route::middleware(['auth'])->group(function () {
    Route::get('carrito', [CartController::class, 'index'])->name('carrito');
    Route::post('carrito/agregar/{product}', [CartController::class, 'add'])->name('carrito.add');
    Route::post('carrito/actualizar/{product}', [CartController::class, 'update'])->name('carrito.update');
    Route::post('carrito/eliminar/{product}', [CartController::class, 'remove'])->name('carrito.remove');
    // Pedidos
    Route::post('carrito/confirmar', [OrderController::class, 'store'])->name('carrito.confirmar');
    Route::get('pedidos', [OrderController::class, 'index'])->name('pedidos');
    Route::get('pedidos-artesano', [OrderController::class, 'artesanoPedidos'])->name('pedidos.artesano');
    Route::post('pedidos-artesano/{order}/estado', [OrderController::class, 'updateEstado'])->name('pedidos.artesano.estado');
    Route::get('factura/{order}', [OrderController::class, 'facturaPDF'])->name('factura.pdf');
});

