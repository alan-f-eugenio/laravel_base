<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductAttributeAdminRequest;
use App\Http\Requests\Admin\ProductAttributeOptAdminRequest;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOpt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductAttributeController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
        $query = ProductAttribute::orderBy('id', 'desc');

        $request->whenFilled('name', function ($value) use ($query) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });

        return view('admin.product_attributes.index', ['collection' => $query->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
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

        return view('admin.product_attributes.create_edit', ['item' => $item, 'listOptions' => $listOptions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeAdminRequest $request, ProductAttributeOptAdminRequest $optsRequest) {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductAttribute $product_attribute) {
        //
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

        return view('admin.product_attributes.create_edit', ['item' => $product_attribute, 'listOptions' => $listOptions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeAdminRequest $request, ProductAttributeOptAdminRequest $optsRequest, ProductAttribute $product_attribute) {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAttribute $product_attribute) {
        //
        if ($product_attribute->options->count()) {
            foreach ($product_attribute->options as $opt) {
                $pcao = new ProductAttributeOptController;
                $pcao->destroy($opt);
            }
        }

        $product_attribute->update(['update_user_id' => auth('admin')->id()]);
        $product_attribute->delete();

        return redirect()->route('admin.product_attributes.index')->with('message', ['type' => 'success', 'text' => 'Atributo removido com sucesso.']);
    }
}
