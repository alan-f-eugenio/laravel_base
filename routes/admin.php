<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\DefineController as AdminDefineController;
use App\Http\Controllers\Admin\IntegrationController as AdminIntegrationController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware('auth:admin', 'auth.session')->group(function () {
        Route::get('/', fn () => view('admin.dashboard'))->name('admin');

        Route::prefix('profile')->group(function () {
            Route::get('/', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::patch('/', [AdminProfileController::class, 'update'])->name('admin.profile.update');
            Route::delete('/', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');
        });

        Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('stripEmptyParams');
        Route::resource('users', AdminUserController::class)->except('index', 'show')->names('admin.users');

        Route::get('defines', [AdminDefineController::class, 'edit'])->name('admin.defines.edit');
        Route::put('defines', [AdminDefineController::class, 'update'])->name('admin.defines.update');

        Route::get('integrations', [AdminIntegrationController::class, 'edit'])->name('admin.integrations.edit');
        Route::put('integrations', [AdminIntegrationController::class, 'update'])->name('admin.integrations.update');
    });

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
    });
});
