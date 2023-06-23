<?php

use Illuminate\Support\Facades\Route;
use Modules\Content\Http\Controllers\AdminContentController;
use Modules\Content\Http\Controllers\AdminContentImageController;
use Modules\Content\Http\Controllers\AdminContentNavController;
use Modules\Content\Http\Controllers\ContentController;
use Modules\Content\Http\Controllers\ContentNavController;

Route::prefix('conteudo')->group(function () {
    Route::get('{nav:slug}', ContentNavController::class)->name('content_nav');
    Route::get('{nav:slug}/{content:slug}', ContentController::class)->name('content');
});

Route::prefix('admin')->middleware('auth:admin', 'auth.session')->group(function () {
    Route::get('contents/{nav}', [AdminContentController::class, 'index'])->name('admin.contents.index')->middleware('stripEmptyParams');
    Route::resource('contents/{nav}', AdminContentController::class)->only('create', 'store')->names('admin.contents');
    Route::resource('contents', AdminContentController::class)->only('edit', 'update', 'destroy')->names('admin.contents');

    Route::get('contentNavs', [AdminContentNavController::class, 'index'])->name('admin.contentNavs.index')->middleware('stripEmptyParams');
    Route::resource('contentNavs', AdminContentNavController::class)->except('index', 'show')->names('admin.contentNavs');

    Route::resource('content_images', AdminContentImageController::class)->only('index', 'store')->names('admin.content_images');
    Route::delete('content_images', [AdminContentImageController::class, 'destroy'])->name('admin.content_images.destroy');
});
