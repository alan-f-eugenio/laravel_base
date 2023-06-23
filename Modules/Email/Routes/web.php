<?php

use Illuminate\Support\Facades\Route;
use Modules\Email\Http\Controllers\AdminEmailController;
use Modules\Email\Http\Controllers\EmailController;

Route::resource('emails', EmailController::class)->only('store');

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('emails', [AdminEmailController::class, 'index'])->name('admin.emails.index')->middleware('stripEmptyParams');
    Route::delete('emails/{email}', [AdminEmailController::class, 'destroy'])->name('admin.emails.destroy');
});
