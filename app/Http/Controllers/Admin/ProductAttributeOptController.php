<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttributeOpt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductAttributeOptController extends Controller {
    public function index(Request $request) {
        $items = [];
        $listOpts = ProductAttributeOpt::where('product_attribute_id', $request->attribute)->orderBy('ordem', 'asc')->get();
        foreach ($listOpts as $opt) {
            $items[] = ['id' => $opt->id, 'name' => $opt->name];
        }

        return stripslashes(json_encode($items));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAttributeOpt $product_attribute_opt) {
        //
        Storage::delete('public/' . $product_attribute_opt->filename);
        $product_attribute_opt->update(['update_user_id' => auth('admin')->id()]);
        $product_attribute_opt->delete();
    }
}
