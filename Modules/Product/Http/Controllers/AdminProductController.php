<?php

namespace Modules\Product\Http\Controllers;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductAttribute;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Entities\ProductFile;
use Modules\Product\Entities\ProductRelated;
use Modules\Product\Entities\ProductSecondaryCategory;
use Modules\Product\Helpers\ProductHasChildTypes;
use Modules\Product\Helpers\ProductTypes;
use Modules\Product\Http\Requests\AdminProductChildRequest;
use Modules\Product\Http\Requests\AdminProductRequest;

class AdminProductController extends Controller {
    public function index(Request $request) {
        //
        $query = Product::whereNull('id_parent')->orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('product::admin.product.index', ['collection' => $query->paginate(10)]);
    }

    public function create() {
        $item = new Product;
        $categories = ProductCategory::whereNull('id_parent')->where('status', DefaultStatus::STATUS_ATIVO->value)->with('allChilds')->get();
        $attributes = ProductAttribute::where('status', DefaultStatus::STATUS_ATIVO->value)->get();

        $listSecondaryCat = [];
        if (old('product_secondary_category_id')) {
            foreach (old('product_secondary_category_id') as $secCat) {
                $listSecondaryCat[] = $secCat;
            }
        }

        $listRelatedProducts = [];
        if (old('product_related_id')) {
            foreach (old('product_related_id') as $related_id) {
                $oldRelated = Product::firstWhere('id', $related_id);
                $listRelatedProducts[] = $oldRelated;
            }
        }

        $listChilds = old('child_ordem') ? new Collection : $item->childs;
        if (old('child_ordem')) {
            foreach (old('child_ordem') as $keyOpt => $optOrdem) {
                $oldOpt = new Product([
                    'product_att1_id' => old('product_att1_id'),
                    'product_att2_id' => old('product_att2_id'),

                    'product_opt1_id' => old('child_opt1')[$keyOpt],
                    'product_opt2_id' => old('child_opt2') ? old('child_opt2')[$keyOpt] : null,
                    'ordem' => $optOrdem,
                    'id' => old('child_id')[$keyOpt],
                    'sku' => old('child_sku')[$keyOpt],
                    'ean' => old('child_ean')[$keyOpt],
                    'price_cost' => old('child_price_cost') ? str_replace('.', ',', old('child_price_cost')[$keyOpt]) : null,
                    'price' => old('child_price') ? str_replace('.', ',', old('child_price')[$keyOpt]) : null,
                    'promo_value' => old('child_promo_value') ? str_replace('.', ',', old('child_promo_value')[$keyOpt]) : null,
                    'weight' => old('child_weight') ? str_replace('.', ',', old('child_weight')[$keyOpt]) : null,
                    'width' => old('child_width') ? str_replace('.', ',', old('child_width')[$keyOpt]) : null,
                    'height' => old('child_height') ? str_replace('.', ',', old('child_height')[$keyOpt]) : null,
                    'depth' => old('child_depth') ? str_replace('.', ',', old('child_depth')[$keyOpt]) : null,
                    'stock' => old('child_stock') ? old('child_stock')[$keyOpt] : null,
                ]);
                $listChilds->push($oldOpt);
            }
        }

        $productTypes = ProductTypes::array();
        $productHasChildTypes = ProductHasChildTypes::array();

        return view('product::admin.product.create_edit', [
            'item' => $item,
            'categories' => $categories,
            'listSecondaryCat' => $listSecondaryCat,
            'listRelatedProducts' => $listRelatedProducts,
            'attributes' => $attributes,
            'listChilds' => $listChilds,
            'inPromo' => old('promo_value') || (bool) $item->promo_value,
            'typeOrca' => (old('type') ?: $item->type?->value) == ProductTypes::TYPE_QUOTE->value,
            'hasChild' => old('has_child') ?: $item->has_child?->value,
            'productTypes' => $productTypes,
            'productHasChildTypes' => $productHasChildTypes,
        ]);
    }

    public function store(AdminProductRequest $request, AdminProductChildRequest $childRequest) {
        $attributes = $request->validated();
        $attributes['slug'] = str($attributes['name'])->slug();
        $attributes['create_user_id'] = auth('admin')->id();

        $listFiles = [];
        if (isset($attributes['filenames'])) {
            foreach (request()->file('filenames') as $keyFile => $file) {
                if (!$keyFile) {
                    $attributes['filename'] = $file->store('products', 'public');
                } else {
                    $listFiles[] = ['filename' => $file->store('products', 'public'), 'type' => $file->getClientMimeType()];
                }
            }
        }
        $childAttributes = $childRequest->validated();

        DB::transaction(function () use ($attributes, $childAttributes, $listFiles) {
            $product = Product::create($attributes);

            if (isset($attributes['product_secondary_category_id'])) {
                foreach ($attributes['product_secondary_category_id'] as $secCatId) {
                    ProductSecondaryCategory::create([
                        'product_id' => $product->id,
                        'product_category_id' => $secCatId,
                    ]);
                }
            }

            if (isset($attributes['product_related_id'])) {
                foreach ($attributes['product_related_id'] as $related_id) {
                    ProductRelated::create([
                        'product_id' => $product->id,
                        'product_id2' => $related_id,
                    ]);
                }
            }

            foreach ($listFiles as $keyF => $file) {
                ProductFile::create([
                    'product_id' => $product->id,
                    'ordem' => $keyF + 1,
                    'filename' => $file['filename'],
                    'type' => $file['type'],
                ]);
            }

            if ($attributes['has_child'] && $childAttributes) {
                foreach ($childAttributes['child_sku'] as $keySku => $childSku) {
                    $listFilenames = request()->file('child_filename');
                    $filename = isset($childAttributes['child_filename']) && $childAttributes['child_filename'][$keySku] ? $listFilenames[$keySku]->store('products', 'public') : null;

                    Product::create([
                        'id_parent' => $product->id,
                        'type' => $attributes['type'],
                        'deadline' => isset($attributes['deadline']) ? $attributes['deadline'] : null,
                        'promo_date_in' => isset($attributes['promo_date_in']) ? $attributes['promo_date_in'] : null,
                        'promo_date_end' => isset($attributes['promo_date_end']) ? $attributes['promo_date_end'] : null,
                        'product_att1_id' => $attributes['product_att1_id'],
                        'product_att2_id' => isset($attributes['product_att2_id']) ? $attributes['product_att2_id'] : null,
                        'product_category_id' => $attributes['product_category_id'],
                        'create_user_id' => auth('admin')->id(),

                        'ordem' => $childAttributes['child_ordem'][$keySku],
                        'product_opt1_id' => $childAttributes['child_opt1'][$keySku],
                        'product_opt2_id' => isset($childAttributes['child_opt2']) ? $childAttributes['child_opt2'][$keySku] : null,
                        'sku' => $childSku,
                        'name' => $childSku,
                        'slug' => str($childSku)->slug(),
                        'ean' => $childAttributes['child_ean'][$keySku] ?: null,
                        'price_cost' => isset($childAttributes['child_price_cost']) ? $childAttributes['child_price_cost'][$keySku] : null,
                        'price' => isset($childAttributes['child_price']) ? $childAttributes['child_price'][$keySku] : null,
                        'weight' => isset($childAttributes['child_weight']) ? $childAttributes['child_weight'][$keySku] : null,
                        'width' => isset($childAttributes['child_width']) ? $childAttributes['child_width'][$keySku] : null,
                        'height' => isset($childAttributes['child_height']) ? $childAttributes['child_height'][$keySku] : null,
                        'depth' => isset($childAttributes['child_depth']) ? $childAttributes['child_depth'][$keySku] : null,
                        'promo_value' => isset($childAttributes['child_promo_value']) ? $childAttributes['child_promo_value'][$keySku] : null,
                        'stock' => isset($childAttributes['child_stock']) ? $childAttributes['child_stock'][$keySku] : null,
                        'filename' => $filename,
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('message', ['type' => 'success', 'text' => 'Produto(s) cadastrado(s) com sucesso.']);
    }

    public function edit(Product $product) {
        $categories = ProductCategory::whereNull('id_parent')->where('status', DefaultStatus::STATUS_ATIVO->value)->with('allChilds')->get();
        $attributes = ProductAttribute::where('status', DefaultStatus::STATUS_ATIVO->value)->get();

        $listSecondaryCat = [];
        if (old('product_secondary_category_id')) {
            foreach (old('product_secondary_category_id') as $secCat) {
                $listSecondaryCat[] = $secCat;
            }
        } else {
            foreach ($product->secondaryCategories as $secCat) {
                $listSecondaryCat[] = $secCat->id;
            }
        }

        $listRelatedProducts = [];
        if (old('product_related_id')) {
            foreach (old('product_related_id') as $related_id) {
                $oldRelated = Product::firstWhere('id', $related_id);
                $listRelatedProducts[] = $oldRelated;
            }
        } else {
            foreach ($product->relatedProducts as $related) {
                $listRelatedProducts[] = $related;
            }
        }

        $listChilds = old('child_ordem') ? new Collection : $product->childs;
        if (old('child_ordem')) {
            foreach (old('child_ordem') as $keyOpt => $optOrdem) {
                $oldOpt = new Product([
                    'product_att1_id' => old('product_att1_id'),
                    'product_att2_id' => old('product_att2_id'),

                    'product_opt1_id' => old('child_opt1')[$keyOpt],
                    'product_opt2_id' => old('child_opt2') ? old('child_opt2')[$keyOpt] : null,
                    'ordem' => $optOrdem,
                    'id' => old('child_id')[$keyOpt],
                    'sku' => old('child_sku')[$keyOpt],
                    'ean' => old('child_ean')[$keyOpt],
                    'child_price_cost' => old('child_price_cost') ? old('child_price_cost')[$keyOpt] : null,
                    'child_price' => old('child_price') ? old('child_price')[$keyOpt] : null,
                    'child_promo_value' => old('child_promo_value') ? old('child_promo_value')[$keyOpt] : null,
                    'child_weight' => old('child_weight') ? old('child_weight')[$keyOpt] : null,
                    'child_width' => old('child_width') ? old('child_width')[$keyOpt] : null,
                    'child_height' => old('child_height') ? old('child_height')[$keyOpt] : null,
                    'child_depth' => old('child_depth') ? old('child_depth')[$keyOpt] : null,
                    'child_stock' => old('child_stock') ? old('child_stock')[$keyOpt] : null,
                ]);
                $listChilds->push($oldOpt);
            }
        }

        $productTypes = ProductTypes::array();
        $productHasChildTypes = ProductHasChildTypes::array();

        return view('product::admin.product.create_edit', [
            'item' => $product,
            'categories' => $categories,
            'listSecondaryCat' => $listSecondaryCat,
            'listRelatedProducts' => $listRelatedProducts,
            'attributes' => $attributes,
            'listChilds' => $listChilds,
            'inPromo' => old('promo_value') || (bool) $product->promo_value,
            'typeOrca' => (old('type') ?: $product->type?->value) == ProductTypes::TYPE_QUOTE->value,
            'hasChild' => old('has_child') ?: $product->has_child?->value,
            'productTypes' => $productTypes,
            'productHasChildTypes' => $productHasChildTypes,
        ]);
    }

    public function update(AdminProductRequest $request, AdminProductChildRequest $childRequest, Product $product) {
        $attributes = $request->validated();
        $attributes['slug'] = str($attributes['name'])->slug();
        $attributes['update_user_id'] = auth('admin')->id();

        $listFiles = [];
        $listOldFiles = [];
        $listAllFiles = [];
        if ($product->images->count()) {
            foreach ($product->images as $pf) {
                $listOldFiles[] = $pf->filename;
            }
        }
        $attributes['filename'] = null;
        if (isset($attributes['filenames'])) {
            foreach (request()->file('filenames') as $keyFile => $file) {
                $listAllFiles[] = $file->getClientOriginalName();
                if (!$keyFile) {
                    if ('products/' . $file->getClientOriginalName() != $product->filename) {
                        Storage::delete('public/' . $product->filename);
                        $attributes['filename'] = $file->store('products', 'public');
                    } else {
                        $attributes['filename'] = $product->filename;
                    }
                } else {
                    if (!in_array($file->getClientOriginalName(), $listOldFiles)) {
                        $listFiles[] = ['filename' => $file->store('products', 'public'), 'type' => $file->getClientMimeType()];
                    }
                }
            }
        }

        $childAttributes = $childRequest->validated();

        DB::transaction(function () use ($product, $attributes, $childAttributes, $listFiles, $listOldFiles, $listAllFiles) {
            $product->update($attributes);

            $listOldSecCats = [];
            $listAllSecCats = [];
            foreach ($product->secondaryCategories as $secCat) {
                $listOldSecCats[] = $secCat->id;
            }
            if (isset($attributes['product_secondary_category_id'])) {
                foreach ($attributes['product_secondary_category_id'] as $secCatId) {
                    $listAllSecCats[] = $secCatId;
                    if (!in_array($secCatId, $listOldSecCats)) {
                        ProductSecondaryCategory::create([
                            'product_id' => $product->id,
                            'product_category_id' => $secCatId,
                        ]);
                    }
                }
            }

            foreach ($product->secondaryCategories as $secCat) {
                if (!in_array($secCat->id, $listAllSecCats)) {
                    $secCat->delete();
                }
            }

            $listOldRelProd = [];
            $listAllRelProd = [];
            foreach ($product->relatedProducts as $related) {
                $listOldRelProd[] = $related->id;
            }
            if (isset($attributes['product_related_id'])) {
                foreach ($attributes['product_related_id'] as $related_id) {
                    $listAllRelProd[] = $related_id;
                    if (!in_array($related_id, $listOldRelProd)) {
                        ProductRelated::create([
                            'product_id' => $product->id,
                            'product_id2' => $related_id,
                        ]);
                    }
                }
            }
            foreach ($product->relatedProducts as $related) {
                if (!in_array($related->id, $listAllRelProd)) {
                    ProductRelated::where('product_id', $product->id)->where('product_id2', $related->id)->delete();
                }
            }

            if ($listOldFiles) {
                foreach ($product->images as $pf) {
                    if (!in_array($pf->filename, $listAllFiles)) {
                        Storage::delete('public/' . $pf->filename);
                        $pf->delete();
                    }
                }
            }

            foreach ($listFiles as $keyF => $file) {
                ProductFile::create([
                    'product_id' => $product->id,
                    'ordem' => $keyF + 1,
                    'filename' => $file['filename'],
                    'type' => $file['type'],
                ]);
            }

            $listChildIds = [];
            if ($attributes['has_child'] && $childAttributes) {
                foreach ($childAttributes['child_sku'] as $keySku => $childSku) {
                    $childAttArray = [
                        'id_parent' => $product->id,
                        'type' => $attributes['type'],
                        'deadline' => isset($attributes['deadline']) ? $attributes['deadline'] : null,
                        'promo_date_in' => isset($attributes['promo_date_in']) ? $attributes['promo_date_in'] : null,
                        'promo_date_end' => isset($attributes['promo_date_end']) ? $attributes['promo_date_end'] : null,
                        'product_att1_id' => $attributes['product_att1_id'],
                        'product_att2_id' => isset($attributes['product_att2_id']) ? $attributes['product_att2_id'] : null,
                        'product_category_id' => $attributes['product_category_id'],

                        'id' => $childAttributes['child_id'][$keySku] ?: null,
                        'create_user_id' => !$childAttributes['child_id'][$keySku] ? auth('admin')->id() : null,
                        'update_user_id' => $childAttributes['child_id'][$keySku] ? auth('admin')->id() : null,
                        'ordem' => $childAttributes['child_ordem'][$keySku],
                        'product_opt1_id' => $childAttributes['child_opt1'][$keySku],
                        'product_opt2_id' => isset($childAttributes['child_opt2']) ? $childAttributes['child_opt2'][$keySku] : null,
                        'sku' => $childSku,
                        'name' => $childSku,
                        'slug' => str($childSku)->slug(),
                        'ean' => $childAttributes['child_ean'][$keySku] ?: null,
                        'price_cost' => isset($childAttributes['child_price_cost']) ? $childAttributes['child_price_cost'][$keySku] : null,
                        'price' => isset($childAttributes['child_price']) ? $childAttributes['child_price'][$keySku] : null,
                        'weight' => isset($childAttributes['child_weight']) ? $childAttributes['child_weight'][$keySku] : null,
                        'width' => isset($childAttributes['child_width']) ? $childAttributes['child_width'][$keySku] : null,
                        'height' => isset($childAttributes['child_height']) ? $childAttributes['child_height'][$keySku] : null,
                        'depth' => isset($childAttributes['child_depth']) ? $childAttributes['child_depth'][$keySku] : null,
                        'promo_value' => isset($childAttributes['child_promo_value']) ? $childAttributes['child_promo_value'][$keySku] : null,
                        'stock' => isset($childAttributes['child_stock']) ? $childAttributes['child_stock'][$keySku] : null,
                    ];

                    if (isset($childAttributes['child_filename'][$keySku])) {
                        if ($childAttributes['child_id'][$keySku]) {
                            if ($child = Product::firstWhere('id', $childAttributes['child_id'][$keySku])) {
                                Storage::delete('public/' . $child->filename);
                            }
                        }
                        $childAttArray['filename'] = request()->file('child_filename')[$keySku]->store('products', 'public');
                    }

                    $child = Product::updateOrCreate(
                        ['id' => $childAttArray['id']],
                        $childAttArray
                    );
                    $listChildIds[] = $child->id;
                }
            }
            foreach ($product->childs as $oldChild) {
                if (!in_array($oldChild->id, $listChildIds)) {
                    Storage::delete('public/' . $oldChild->filename);
                    $oldChild->delete();
                }
            }
        });

        return redirect()->route('admin.products.edit', $product)->with('message', ['type' => 'success', 'text' => 'Produto(s) alterado(s) com sucesso.']);
    }

    public function destroy(Product $product, $returnView = true) {
        if ($product->childs->count()) {
            foreach ($product->childs as $child) {
                $pc = new AdminProductController;
                $pc->destroy($child, false);
            }
        }

        Storage::delete('public/' . $product->filename);

        $product->update(['update_user_id' => auth('admin')->id()]);
        $product->delete();

        if ($returnView) {
            return redirect()->route('admin.products.index')->with('message', ['type' => 'success', 'text' => 'Produto(s) removido(s) com sucesso.']);
        }
    }

    public function search(Request $request) {
        $json = json_encode([]);

        if ($request->name) {
            $query = Product::whereNull('id_parent')->where('status', DefaultStatus::STATUS_ATIVO->value)->orderBy('id', 'desc');
            if ($request->except) {
                $query->whereNot('id', $request->except);
            }
            $query->where('name', 'LIKE', "%{$request->name}%");
            if ($listProduct = $query->limit(10)->get()) {
                return json_encode($listProduct->map(function ($item) {
                    return ['id' => $item->id, 'name' => $item->name];
                }));
            }
        }

        return $json;
    }
}
