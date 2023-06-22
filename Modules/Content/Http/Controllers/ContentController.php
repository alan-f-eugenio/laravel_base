<?php

namespace Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Content\Entities\Content;
use Modules\Content\Entities\ContentNav;

class ContentController extends Controller {
    public function __invoke(Request $request, ContentNav $nav, Content $content) {
        return view('content::public.content.index', ['item' => $content]);
    }
}
