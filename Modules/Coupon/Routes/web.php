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
use Modules\Coupon\Http\Controllers\AdminCouponController;
use Modules\Coupon\Http\Controllers\CouponController;

Route::get('coupon_calc', CouponController::class)->name('coupon_calc');

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('coupons', [AdminCouponController::class, 'index'])->name('admin.coupons.index')->middleware('stripEmptyParams');
    Route::resource('coupons', AdminCouponController::class)->except('index', 'show')->names('admin.coupons');
});
