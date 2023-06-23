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
use Modules\Bling\Http\Controllers\BlingController;

Route::get('bling_produtos', [BlingController::class, 'getAllProducts'])->name('bling_produtos');
