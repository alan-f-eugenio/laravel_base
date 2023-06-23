<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\AdminCustomerController;
use Modules\Customer\Http\Controllers\Auth\AuthenticatedSessionController;
use Modules\Customer\Http\Controllers\Auth\ConfirmablePasswordController;
use Modules\Customer\Http\Controllers\Auth\EmailVerificationNotificationController;
use Modules\Customer\Http\Controllers\Auth\EmailVerificationPromptController;
use Modules\Customer\Http\Controllers\Auth\NewPasswordController;
use Modules\Customer\Http\Controllers\Auth\PasswordController;
use Modules\Customer\Http\Controllers\Auth\PasswordResetLinkController;
use Modules\Customer\Http\Controllers\Auth\RegisteredUserController;
use Modules\Customer\Http\Controllers\Auth\VerifyEmailController;
use Modules\Customer\Http\Controllers\CustomerAddressController;
use Modules\Customer\Http\Controllers\CustomerController;
use Modules\Customer\Http\Controllers\CustomerPasswordController;

Route::middleware('guest:web')->prefix('cadastrar')->group(function () {
    Route::get('/', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/', [CustomerController::class, 'store'])->name('customer.store');
});

Route::middleware('auth:web', 'auth.session')->prefix('minha-conta')->group(function () {
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

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index')->middleware('stripEmptyParams');
    Route::resource('customers', AdminCustomerController::class)->except('index', 'show')->names('admin.customers');
});

Route::middleware('guest:web')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth:web', 'auth.session')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
