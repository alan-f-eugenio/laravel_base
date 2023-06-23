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
use Modules\Banner\Http\Controllers\AdminBannerController;

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('banners', [AdminBannerController::class, 'index'])->name('admin.banners.index')->middleware('stripEmptyParams');
    Route::resource('banners', AdminBannerController::class)->except('index', 'show')->names('admin.banners');
    Route::put('banners_order', [AdminBannerController::class, 'updateOrdenation'])->name('admin.banners_order');
});
