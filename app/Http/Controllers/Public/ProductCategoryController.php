<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller {
    // public function __invoke(Request $request, ProductCategory $product_category) {
    //     $products = Product::where('product_category_id', $product_category->id)->orWhereHas('secondaryCategories', function ($query) use ($product_category) {
    //         $query->where('product_category_id', $product_category->id);
    //     })->get();

    //     return view('public.product_categories.index', ['products' => $products, 'category' => $product_category]);
    // }
}
