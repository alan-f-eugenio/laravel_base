<?php

use App\Helpers\DefaultStatus;
use App\Http\Controllers\Integrations\BlingController;
use App\Http\Controllers\Public\CartProductController;
use App\Http\Controllers\Public\CouponController;
use App\Http\Controllers\Public\CustomerAddressController;
use App\Http\Controllers\Public\CustomerController;
use App\Http\Controllers\Public\CustomerPasswordController;
use App\Http\Controllers\Public\PaymentController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\ShippingController;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Route;
use Modules\Banner\Entities\Banner;
use Modules\Contact\Http\Controllers\ContactController;
use Modules\Content\Http\Controllers\ContentController;
use Modules\Content\Http\Controllers\ContentNavController;
use Modules\Email\Http\Controllers\EmailController;

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
    $banner = Banner::first();

    $contNavSingle = config('contentNavs') ? current(array_filter(config('contentNavs'), fn ($nav) => ($nav->type->single() && $nav->contents->count()))) : null;
    if ($contNavSingle) {
        $contentSingle = $contNavSingle->contents->first();
    }

    $contMultiNav = config('contentNavs') ? current(array_filter(config('contentNavs'), fn ($nav) => ($nav->type->multiple() && $nav->contents->count()))) : null;
    if ($contMultiNav) {
        $contentMultiple = [
            'nav' => $contMultiNav,
            'items' => $contMultiNav->contents,
        ];
    }

    $categories = ProductCategory::where('status', DefaultStatus::STATUS_ATIVO->value)->with(['products', 'secondaryProducts'])->get();

    return view('public.home', [
        'banner' => $banner,
        'contentSingle' => isset($contentSingle) ? $contentSingle : null,
        'contentMultiple' => isset($contentMultiple) ? $contentMultiple : null,
        'categories' => $categories,
    ]);
})->name('home');

Route::resource('contacts', ContactController::class)->only('store');
Route::resource('emails', EmailController::class)->only('store');

Route::prefix('conteudo')->group(function () {
    Route::get('{nav:slug}', ContentNavController::class)->name('content_nav');
    Route::get('{nav:slug}/{content:slug}', ContentController::class)->name('content');
});

Route::prefix('produtos')->group(function () {
    Route::get('{product_category:slug?}', [ProductController::class, 'index'])->name('products.index');
    Route::get('{product_category:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');
});

Route::prefix('carrinho')->group(function () {
    Route::get('/', [CartProductController::class, 'index'])->name('cart_product.index');
    Route::post('{product}', [CartProductController::class, 'store'])->name('cart_product.store');
});
Route::resource('cart_product', CartProductController::class)->only('update', 'destroy');

Route::get('shipping_calc', ShippingController::class)->name('shipping_calc');
Route::get('coupon_calc', CouponController::class)->name('coupon_calc');
Route::get('bling_produtos', [BlingController::class, 'getAllProducts'])->name('bling_produtos');

Route::middleware('guest')->prefix('cadastrar')->group(function () {
    Route::get('/', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/', [CustomerController::class, 'store'])->name('customer.store');
});

Route::middleware('auth', 'auth.session')->group(function () {
    Route::prefix('minha-conta')->group(function () {
        Route::get('/', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/', [CustomerController::class, 'update'])->name('customer.update');

        Route::get('senha', [CustomerPasswordController::class, 'edit'])->name('customer_password.edit');
        Route::put('senha', [CustomerPasswordController::class, 'update'])->name('customer_password.update');

        Route::get('enderecos', [CustomerAddressController::class, 'index'])->name('customer_address.index');
        Route::get('endereco/cadastrar', [CustomerAddressController::class, 'create'])->name('customer_address.create');
        Route::post('endereco/cadastrar', [CustomerAddressController::class, 'store'])->name('customer_address.store');
        Route::get('endereco/{customer_address}', [CustomerAddressController::class, 'edit'])->name('customer_address.edit');
        Route::put('endereco/{customer_address}', [CustomerAddressController::class, 'update'])->name('customer_address.update');
    });

    Route::resource('checkout', PaymentController::class)->only('index', 'store')->names('payment');
});

Route::post('paymentNotification/{paymentMethod}', [PaymentController::class, 'update'])->name('paymentNotification');

require __DIR__ . '/admin.php';
require __DIR__ . '/public_auth.php';
