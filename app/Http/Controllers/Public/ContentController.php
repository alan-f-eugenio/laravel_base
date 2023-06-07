<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentNav;
use Illuminate\Http\Request;

class ContentController extends Controller {
    public function __invoke(Request $request, ContentNav $nav, Content $content) {
        // dd($request);
        return view('public.contents.index', ['item' => $content]);
    }
}
