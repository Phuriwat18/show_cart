<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();




Route::get('/home', [App\Http\Controllers\ProductController::class, 'show'])->name('home');


Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);

// Route::get('/receipt/{id}', [ReceiptController::class, 'show'])->name('receipt.show');
// Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

Route::get('/order/{id}/receipt', [OrderController::class, 'showReceipt'])->name('order.receipt');
Route::get('/orders/bil/{orderId}', [OrderController::class, 'showBil'])->name('orders.bil');
Route::put('/orders/bil/{orderId}', [OrderController::class, 'updateBil'])->name('orders.updateBil');
// routes/web.php
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');


Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'report'])->name('orders.report');
    // หน้าแสดงสินค้า
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    // สร้างสินค้า
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    
    // แก้ไขสินค้า
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    
    // ลบสินค้า
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});


