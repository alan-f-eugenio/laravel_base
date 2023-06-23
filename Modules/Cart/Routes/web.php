<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\AdminCartController;
use Modules\Cart\Http\Controllers\CartProductController;

Route::prefix('carrinho')->group(function () {
    Route::get('/', [CartProductController::class, 'index'])->name('cart_product.index');
    Route::post('{product}', [CartProductController::class, 'store'])->name('cart_product.store');
});
Route::resource('cart_product', CartProductController::class)->only('update', 'destroy');

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('carts', [AdminCartController::class, 'index'])->name('admin.carts.index')->middleware('stripEmptyParams');
    Route::delete('carts/{cart}', [AdminCartController::class, 'destroy'])->name('admin.carts.destroy');
});
