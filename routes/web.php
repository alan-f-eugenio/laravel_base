<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\DefaultStatus;

use Modules\Banner\Entities\Banner;
use Modules\Bling\Http\Controllers\BlingController;
use Modules\Coupon\Http\Controllers\CouponController;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Product\Entities\ProductCategory;
use Modules\Shipping\Http\Controllers\ShippingController;

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

Route::get('shipping_calc', ShippingController::class)->name('shipping_calc');
Route::get('coupon_calc', CouponController::class)->name('coupon_calc');
Route::get('bling_produtos', [BlingController::class, 'getAllProducts'])->name('bling_produtos');

Route::middleware('auth:web', 'auth.session')->group(function () {
    Route::resource('checkout', PaymentController::class)->only('index', 'store')->names('payment');
});

Route::post('paymentNotification/{paymentMethod}', [PaymentController::class, 'update'])->name('paymentNotification');

require __DIR__ . '/admin.php';
