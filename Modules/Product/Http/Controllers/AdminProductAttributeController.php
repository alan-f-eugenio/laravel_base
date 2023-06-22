<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\ProductAttribute;
use Modules\Product\Entities\ProductAttributeOpt;
use Modules\Product\Http\Requests\AdminProductAttributeOptRequest;
use Modules\Product\Http\Requests\AdminProductAttributeRequest;

class AdminProductAttributeController extends Controller {
    public function index(Request $request) {
        $query = ProductAttribute::orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('product::admin.product_attribute.index', ['collection' => $query->paginate(10)]);
    }

    public function create() {
        $item = new ProductAttribute;

        $listOptions = old('option_ordem') ? new Collection : $item->options;
        if (old('option_ordem')) {
            foreach (old('option_ordem') as $keyOpt => $optOrdem) {
                $oldOpt = new ProductAttributeOpt([
                    'ordem' => $optOrdem,
                    'id' => old('option_id')[$keyOpt],
                    'name' => old('option_name')[$keyOpt],
                    'created_at' => old('option_created_at')[$keyOpt],
                ]);
                $listOptions->push($oldOpt);
            }
        }

        return view('product::admin.product_attribute.create_edit', ['item' => $item, 'listOptions' => $listOptions]);
    }

    public function store(AdminProductAttributeRequest $request, AdminProductAttributeOptRequest $optsRequest) {
        $attributes = $request->validated();
        $attributes['create_user_id'] = auth('admin')->id();

        $optsAttributes = $optsRequest->validated();

        DB::transaction(function () use ($attributes, $optsAttributes) {
            $product_attribute = ProductAttribute::create($attributes);
            if ($optsAttributes) {
                foreach ($optsAttributes['option_ordem'] as $keyOpt => $optOrdem) {
                    ProductAttributeOpt::create([
                        'create_user_id' => auth('admin')->id(),
                        'ordem' => $optOrdem,
                        'name' => $optsAttributes['option_name'][$keyOpt],
                        'product_attribute_id' => $product_attribute->id,
                    ]);
                }
            }
        });

        return redirect()->route('admin.product_attributes.index')->with('message', ['type' => 'success', 'text' => 'Atributo cadastrado com sucesso.']);
    }

    public function edit(ProductAttribute $product_attribute) {
        $listOptions = old('option_ordem') ? new Collection : $product_attribute->options;
        if (old('option_ordem')) {
            foreach (old('option_ordem') as $keyOpt => $optOrdem) {
                $oldOpt = new ProductAttributeOpt([
                    'ordem' => $optOrdem,
                    'id' => old('option_id')[$keyOpt],
                    'name' => old('option_name')[$keyOpt],
                    'created_at' => old('option_created_at')[$keyOpt],
                ]);
                $listOptions->push($oldOpt);
            }
        }

        return view('product::admin.product_attribute.create_edit', ['item' => $product_attribute, 'listOptions' => $listOptions]);
    }

    public function update(AdminProductAttributeRequest $request, AdminProductAttributeOptRequest $optsRequest, ProductAttribute $product_attribute) {
        $attributes = $request->validated();
        $attributes['update_user_id'] = auth('admin')->id();

        $optsAttributes = $optsRequest->validated();

        DB::transaction(function () use ($product_attribute, $attributes, $optsAttributes) {
            $product_attribute->update($attributes);
            $listOptsIds = [];
            if ($optsAttributes) {
                foreach ($optsAttributes['option_ordem'] as $keyOpt => $optOrdem) {
                    $opt = new ProductAttributeOpt([
                        'ordem' => $optOrdem,
                        'name' => $optsAttributes['option_name'][$keyOpt],
                        'id' => $optsAttributes['option_id'][$keyOpt] ?: null,
                        'product_attribute_id' => $product_attribute->id,
                    ]);
                    if (isset($optsAttributes['option_filename']) && isset($optsAttributes['option_filename'][$keyOpt])) {
                        if ($oldOpt = ProductAttributeOpt::firstWhere('id', $opt->id)) {
                            Storage::delete('public/' . $oldOpt->filename);
                        }
                        $opt->filename = request()->file('option_filename')[$keyOpt]->store('product_attribute_opts', 'public');
                    }
                    $opt = $opt->updateOrCreate(
                        ['id' => $opt->id],
                        [
                            'create_user_id' => !$opt->id ? auth('admin')->id() : null,
                            'update_user_id' => $opt->id ? auth('admin')->id() : null,
                            ...$opt->attributesToArray(),
                        ]
                    );
                    $listOptsIds[] = $opt->id;
                }
            }
            foreach ($product_attribute->options as $oldOpt) {
                if (!in_array($oldOpt->id, $listOptsIds)) {
                    Storage::delete('public/' . $oldOpt->filename);
                    $oldOpt->delete();
                }
            }
        });

        return redirect()->route('admin.product_attributes.edit', $product_attribute)->with('message', ['type' => 'success', 'text' => 'Atributo alterado com sucesso.']);
    }

    public function destroy(ProductAttribute $product_attribute) {
        if ($product_attribute->options->count()) {
            foreach ($product_attribute->options as $opt) {
                $pcao = new AdminProductAttributeOptController;
                $pcao->destroy($opt);
            }
        }

        $product_attribute->update(['update_user_id' => auth('admin')->id()]);
        $product_attribute->delete();

        return redirect()->route('admin.product_attributes.index')->with('message', ['type' => 'success', 'text' => 'Atributo removido com sucesso.']);
    }
}
