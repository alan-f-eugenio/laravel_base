<?php

namespace Modules\Content\Http\Controllers;

use App\Helpers\ContentNavTypes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Content\Entities\ContentNav;

class ContentNavController extends Controller {
    public function __invoke(Request $request, ContentNav $nav) {
        if ($nav->type == ContentNavTypes::TYPE_MULTIPLE) {
            return view('public.content_navs.index', ['collection' => $nav->contents, 'nav' => $nav]);
        }

        return view('public.contents.index', ['item' => $nav->contents->first(), 'nav' => $nav]);
    }
}
