<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\AdminContactController;
use Modules\Contact\Http\Controllers\ContactController;

Route::resource('contacts', ContactController::class)->only('store');

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index')->middleware('stripEmptyParams');
    Route::resource('contacts', AdminContactController::class)->only('show', 'destroy')->names('admin.contacts');
});
