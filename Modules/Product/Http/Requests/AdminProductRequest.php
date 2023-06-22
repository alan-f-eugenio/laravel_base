<?php

namespace Modules\Product\Http\Requests;

use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductAttribute;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Helpers\ProductHasChildTypes;
use Modules\Product\Helpers\ProductTypes;

class AdminProductRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            //
            'status' => ['required', new Enum(DefaultStatus::class)],
            'product_category_id' => ['required', Rule::exists(ProductCategory::class, 'id')->where('status', DefaultStatus::STATUS_ATIVO->value)],
            'product_secondary_category_id.*' => ['nullable', Rule::exists(ProductCategory::class, 'id')->where('status', DefaultStatus::STATUS_ATIVO->value)],
            'sku' => ['required', Rule::unique(Product::class, 'sku')->ignore($this->product?->id)->withoutTrashed()],
            'name' => 'required|string|max:255',
            'ean' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'type' => ['required', new Enum(ProductTypes::class)],
            'price_cost' => 'nullable|decimal:0,2|min:0.01',
            'price' => 'nullable|decimal:0,2|gte:price_cost',
            'weight' => 'nullable|decimal:0,3|min:0.01',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'depth' => 'nullable|integer|min:1',
            'stock' => 'nullable|integer|min:0',
            'deadline' => 'nullable|string|max:255',
            'promo_value' => 'nullable|decimal:0,2|gte:price_cost',
            'promo_date_in' => 'nullable|date',
            'promo_date_end' => 'nullable|date|after:date_start',
            'has_child' => ['required', new Enum(ProductHasChildTypes::class)],
            'product_att1_id' => ['nullable', Rule::exists(ProductAttribute::class, 'id')],
            'product_att2_id' => ['nullable', Rule::exists(ProductAttribute::class, 'id')],
            'page_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'filenames.*' => Rule::forEach(function ($value, $attribute) {
                return 'nullable|image|max:5120';
            }),
            'product_related_id.*' => ['nullable', Rule::exists(Product::class, 'id')->where('status', DefaultStatus::STATUS_ATIVO->value)],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    protected function prepareForValidation(): void {
        $this->merge([
            'price_cost' => $this->has('price_cost') ? str_replace('R$ ', '', str_replace(',', '.', $this->price_cost)) : null,
            'price' => $this->has('price') ? str_replace('R$ ', '', str_replace(',', '.', $this->price)) : null,
            'weight' => $this->has('weight') ? str_replace(',', '.', $this->weight) : null,
            'width' => $this->has('width') ? $this->width : null,
            'height' => $this->has('height') ? $this->height : null,
            'depth' => $this->has('depth') ? $this->depth : null,
            'promo_value' => $this->has('promo_value') ? str_replace('R$ ', '', str_replace(',', '.', $this->promo_value)) : null,
            'has_child' => $this->has('product_att1_id') && $this->has('child_opt1') ? $this->has_child : ProductHasChildTypes::TYPE_NONE->value,
            'product_att1_id' => $this->has('product_att1_id') && $this->has('child_opt1') ? $this->product_att1_id : null,
            'product_att2_id' => $this->has('product_att2_id') && $this->has('child_opt2') ? $this->product_att1_id : null,
        ]);
    }
}
