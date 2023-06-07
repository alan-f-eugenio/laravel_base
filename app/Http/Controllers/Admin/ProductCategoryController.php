<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DefaultStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryAdminRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    public static function recursiveCategoryChild($product_category, $treeList) {
        foreach ($product_category->allChilds as $childCat) {
            $treeList = self::recursiveCategoryChild($childCat, $treeList);
        }

        return [$product_category->id, ...$treeList];
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
        $collection = ProductCategory::whereNull('id_parent')->with('allChilds')->orderBy('ordem', 'asc')->get();

        return view('admin.product_categories.index', ['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
        $item = new ProductCategory;

        $categories = ProductCategory::whereNull('id_parent')->with('allChilds')->get();

        return view('admin.product_categories.create_edit', ['item' => $item, 'categories' => $categories, 'treeList' => []]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryAdminRequest $request) {
        //
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            $attributes['filename'] = request()->file('filename')->store('product_categories', 'public');
        }
        $attributes['create_user_id'] = auth('admin')->id();

        ProductCategory::create($attributes);

        return redirect()->route('admin.product_categories.index')->with('message', ['type' => 'success', 'text' => 'Categoria cadastrada com sucesso.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $product_category) {
        //
        $categories = ProductCategory::whereNull('id_parent')->where('status', DefaultStatus::STATUS_ATIVO->value)->with('allChilds')->get();

        $treeList = self::recursiveCategoryChild($product_category, []);

        return view('admin.product_categories.create_edit', ['item' => $product_category, 'categories' => $categories, 'treeList' => $treeList]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryAdminRequest $request, ProductCategory $product_category) {
        //
        $attributes = $request->validated();

        if (isset($attributes['filename'])) {
            Storage::delete('public/' . $product_category->filename);
            $attributes['filename'] = request()->file('filename')->store('product_categories', 'public');
        }
        $attributes['update_user_id'] = auth('admin')->id();

        $product_category->update($attributes);

        return redirect()->route('admin.product_categories.edit', $product_category)->with('message', ['type' => 'success', 'text' => 'Categoria alterada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $product_category, $returnView = true) {
        //
        if ($product_category->allChilds->count()) {
            foreach ($product_category->allChilds as $child) {
                $pcc = new ProductCategoryController;
                $pcc->destroy($child, false);
            }
        }

        Storage::delete('public/' . $product_category->filename);
        $product_category->update(['update_user_id' => auth('admin')->id()]);
        $product_category->delete();

        if ($returnView) {
            return redirect()->route('admin.product_categories.index')->with('message', ['type' => 'success', 'text' => 'Categoria removida com sucesso.']);
        }
    }

    public function updateOrdenation(Request $request) {

        foreach ($request->all() as $product_categoryTr) {
            if ($product_category = ProductCategory::find($product_categoryTr['id'])) {
                $product_category->timestamps = false;
                $product_category->update(['ordem' => $product_categoryTr['ordem']]);
            }
        }

        return json_encode(['success' => true]);
    }
}
