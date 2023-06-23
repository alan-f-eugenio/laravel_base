<?php

use App\Helpers\DefaultStatus;
use Illuminate\Support\Facades\Route;
use Modules\Banner\Entities\Banner;
use Modules\Product\Entities\ProductCategory;

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

require __DIR__ . '/admin.php';
