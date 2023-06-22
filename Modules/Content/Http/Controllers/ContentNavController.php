<?php

namespace Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Content\Entities\ContentNav;
use Modules\Content\Helpers\ContentNavTypes;

class ContentNavController extends Controller {
    public function __invoke(Request $request, ContentNav $nav) {
        if ($nav->type == ContentNavTypes::TYPE_MULTIPLE) {
            return view('content::public.contentNav.index', ['collection' => $nav->contents, 'nav' => $nav]);
        }

        return view('content::public.content.index', ['item' => $nav->contents->first(), 'nav' => $nav]);
    }
}
