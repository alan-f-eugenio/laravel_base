<?php

namespace App\Http\Controllers\Public;

use App\Helpers\ContentNavTypes;
use App\Http\Controllers\Controller;
use App\Models\ContentNav;
use Illuminate\Http\Request;

class ContentNavController extends Controller {
    public function __invoke(Request $request, ContentNav $nav) {
        // if (!$nav->contents->count()) {
        //     abort(404);
        // }
        if ($nav->type == ContentNavTypes::TYPE_MULTIPLE) {
            return view('public.content_navs.index', ['collection' => $nav->contents, 'nav' => $nav]);
        }

        return view('public.contents.index', ['item' => $nav->contents->first(), 'nav' => $nav]);
    }
}
