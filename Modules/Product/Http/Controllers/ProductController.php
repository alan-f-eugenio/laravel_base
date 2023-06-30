<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cart\Http\Controllers\CartController;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Helpers\ProductTypes;

class ProductController extends Controller {
    public function index(Request $request, ProductCategory $product_category) {

        $products = Product::when($product_category?->id, function (Builder $query, $product_category_id) {
            $query->whereNull('id_parent')->where('product_category_id', $product_category_id)
                ->orWhereHas('secondaryCategories', function ($query) use ($product_category_id) {
                    $query->where('product_category_id', $product_category_id);
                });
        })->whereNull('id_parent')->where(function (Builder $query) {
            $query->where('type', ProductTypes::TYPE_SALE)->whereDoesntHave('childs')
                ->where('stock', '>', 0)->orWhereHas('childs', function ($query) {
                    $query->where('stock', '>', 0);
                })->orWhere('type', ProductTypes::TYPE_QUOTE);
        })->whereHas('category')->with('category')->get();

        return view('product::public.product.index', ['products' => $products, 'category' => $product_category]);
    }

    public function show(Product $product) {
        $cart = CartController::storeOrUpdate();

        return view('product::public.product.show', ['item' => $product, 'cart' => $cart, 'relatedProducts' => $product->relatedProducts]);
    }
}
