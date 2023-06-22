<?php
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;

Route::prefix('produtos')->group(function () {
    Route::get('{product_category:slug?}', [ProductController::class, 'index'])->name('products.index');
    Route::get('{product_category:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');
});
