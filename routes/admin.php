<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DefineController as AdminDefineController;
use App\Http\Controllers\Admin\IntegrationController as AdminIntegrationController;
use App\Http\Controllers\Admin\ProductAttributeController as AdminProductAttributeController;
use App\Http\Controllers\Admin\ProductAttributeOptController as AdminProductAttributeOptController;
use App\Http\Controllers\Admin\ProductCategoryController as AdminProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\AdminBannerController;
use Modules\Contact\Http\Controllers\AdminContactController;
use Modules\Content\Http\Controllers\AdminContentController;
use Modules\Content\Http\Controllers\AdminContentImageController;
use Modules\Content\Http\Controllers\AdminContentNavController;
use Modules\Email\Http\Controllers\AdminEmailController;

Route::prefix('admin')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('admin.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth:admin', 'auth.session')->group(function () {

        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('admin.verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('admin.verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('admin.verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('admin.password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('admin.password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('admin.logout');

        Route::get('/', fn () => view('admin.dashboard'))->name('admin');

        Route::prefix('profile')->group(function () {
            Route::get('/', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::patch('/', [AdminProfileController::class, 'update'])->name('admin.profile.update');
            Route::delete('/', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');
        });

        Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('stripEmptyParams');
        Route::resource('users', AdminUserController::class)->except('index', 'show')->names('admin.users');

        Route::get('contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index')->middleware('stripEmptyParams');
        Route::resource('contacts', AdminContactController::class)->only('show', 'destroy')->names('admin.contacts');

        Route::get('emails', [AdminEmailController::class, 'index'])->name('admin.emails.index')->middleware('stripEmptyParams');
        Route::delete('emails/{email}', [AdminEmailController::class, 'destroy'])->name('admin.emails.destroy');

        Route::get('banners', [AdminBannerController::class, 'index'])->name('admin.banners.index')->middleware('stripEmptyParams');
        Route::resource('banners', AdminBannerController::class)->except('index', 'show')->names('admin.banners');
        Route::put('banners_order', [AdminBannerController::class, 'updateOrdenation'])->name('admin.banners_order');

        Route::get('contents/{nav}', [AdminContentController::class, 'index'])->name('admin.contents.index')->middleware('stripEmptyParams');
        Route::resource('contents/{nav}', AdminContentController::class)->only('create', 'store')->names('admin.contents');
        Route::resource('contents', AdminContentController::class)->only('edit', 'update', 'destroy')->names('admin.contents');

        Route::get('contentNavs', [AdminContentNavController::class, 'index'])->name('admin.contentNavs.index')->middleware('stripEmptyParams');
        Route::resource('contentNavs', AdminContentNavController::class)->except('index', 'show')->names('admin.contentNavs');

        Route::resource('content_images', AdminContentImageController::class)->only('index', 'store')->names('admin.content_images');
        Route::delete('content_images', [AdminContentImageController::class, 'destroy'])->name('admin.content_images.destroy');

        Route::get('defines', [AdminDefineController::class, 'edit'])->name('admin.defines.edit');
        Route::put('defines', [AdminDefineController::class, 'update'])->name('admin.defines.update');

        Route::get('customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index')->middleware('stripEmptyParams');
        Route::resource('customers', AdminCustomerController::class)->except('index', 'show')->names('admin.customers');

        Route::get('coupons', [AdminCouponController::class, 'index'])->name('admin.coupons.index')->middleware('stripEmptyParams');
        Route::resource('coupons', AdminCouponController::class)->except('index', 'show')->names('admin.coupons');

        Route::get('product_categories', [AdminProductCategoryController::class, 'index'])->name('admin.product_categories.index')->middleware('stripEmptyParams');
        Route::resource('product_categories', AdminProductCategoryController::class)->except('index', 'show')->names('admin.product_categories');
        Route::put('product_categories_order', [AdminProductCategoryController::class, 'updateOrdenation'])->name('admin.product_categories_order');

        Route::get('product_attributes', [AdminProductAttributeController::class, 'index'])->name('admin.product_attributes.index')->middleware('stripEmptyParams');
        Route::resource('product_attributes', AdminProductAttributeController::class)->except('index', 'show')->names('admin.product_attributes');

        Route::get('product_attribute_opts', [AdminProductAttributeOptController::class, 'index'])->name('admin.product_attribute_opts.index');

        Route::get('products', [AdminProductController::class, 'index'])->name('admin.products.index')->middleware('stripEmptyParams');
        Route::resource('products', AdminProductController::class)->except('index', 'show')->names('admin.products');
        Route::get('productSearch', [AdminProductController::class, 'search'])->name('admin.products.search');

        Route::get('carts', [AdminCartController::class, 'index'])->name('admin.carts.index')->middleware('stripEmptyParams');
        Route::delete('carts/{cart}', [AdminCartController::class, 'destroy'])->name('admin.carts.destroy');

        Route::get('integrations', [AdminIntegrationController::class, 'edit'])->name('admin.integrations.edit');
        Route::put('integrations', [AdminIntegrationController::class, 'update'])->name('admin.integrations.update');
    });
});
