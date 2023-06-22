<?php

use Illuminate\Support\Facades\Route;
use Modules\Email\Http\Controllers\EmailController;

Route::resource('emails', EmailController::class)->only('store');
