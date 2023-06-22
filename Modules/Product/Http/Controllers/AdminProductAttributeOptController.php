<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\ProductAttributeOpt;

class AdminProductAttributeOptController extends Controller {
    public function index(Request $request) {
        $items = [];
        $listOpts = ProductAttributeOpt::where('product_attribute_id', $request->attribute)->orderBy('ordem', 'asc')->get();
        foreach ($listOpts as $opt) {
            $items[] = ['id' => $opt->id, 'name' => $opt->name];
        }

        return stripslashes(json_encode($items));
    }

    public function destroy(ProductAttributeOpt $product_attribute_opt) {
        Storage::delete('public/' . $product_attribute_opt->filename);
        $product_attribute_opt->update(['update_user_id' => auth('admin')->id()]);
        $product_attribute_opt->delete();
    }
}
