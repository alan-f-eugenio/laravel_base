<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;

Route::middleware('auth:web', 'auth.session')->group(function () {
    Route::resource('checkout', PaymentController::class)->only('index', 'store')->names('payment');
});

Route::post('paymentNotification/{paymentMethod}', [PaymentController::class, 'update'])->name('paymentNotification');
