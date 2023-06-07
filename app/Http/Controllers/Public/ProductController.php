<?php

namespace App\Http\Controllers\Public;

use App\Helpers\ProductTypes;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        // dd($products);

        return view('public.products.index', ['products' => $products, 'category' => $product_category]);
    }

    public function show(ProductCategory $product_category, Product $product) {
        $cart = CartController::storeOrUpdate();

        return view('public.products.show', ['item' => $product, 'cart' => $cart, 'relatedProducts' => $product->relatedProducts]);
    }
}
