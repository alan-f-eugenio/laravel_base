<?php

use Illuminate\Support\Facades\Route;
use Modules\Content\Http\Controllers\ContentController;
use Modules\Content\Http\Controllers\ContentNavController;

Route::prefix('conteudo')->group(function () {
    Route::get('{nav:slug}', ContentNavController::class)->name('content_nav');
    Route::get('{nav:slug}/{content:slug}', ContentController::class)->name('content');
});
