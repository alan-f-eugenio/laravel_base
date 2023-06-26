<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductAttributeOpt;

class AdminProductChildRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'child_id.*' => 'nullable|numeric',
            'child_ordem.*' => 'required|numeric',
            'child_opt1.*' => Rule::forEach(function ($value, $attribute) {
                return [
                    'sometimes',
                    Rule::exists(ProductAttributeOpt::class, 'id')->withoutTrashed(),
                ];
            }),
            'child_opt2.*' => Rule::forEach(function ($value, $attribute) {
                return [
                    'sometimes',
                    Rule::exists(ProductAttributeOpt::class, 'id')->withoutTrashed(),
                ];
            }),
            'child_sku.*' => Rule::forEach(function ($value, $attribute) {
                $index = substr($attribute, strpos($attribute, '.') + 1);
                $listSkus = $this->child_sku;
                unset($listSkus[$index]);
                if (isset($this->child_id) && isset($this->child_id[$index])) {
                    return [
                        'required',
                        Rule::unique(Product::class, 'sku')->ignore($this->child_id[$index])->withoutTrashed(),
                        Rule::notIn([$this->sku, ...$listSkus]),
                    ];
                }

                return [
                    'required',
                    Rule::unique(Product::class, 'sku')->withoutTrashed(),
                    Rule::notIn([$this->sku, ...$listSkus]),
                ];
            }),
            'child_ean.*' => 'nullable|string|max:255',
            'child_price_cost.*' => 'nullable|decimal:0,2|min:0.01',
            // 'child_price.*' => 'nullable|decimal:0,2|gte:child_price_cost',
            'child_price.*' => Rule::forEach(function ($value, $attribute) {
                $index = substr($attribute, strpos($attribute, '.') + 1);
                if (isset($this->child_price_cost) && isset($this->child_price_cost[$index])) {
                    return [
                        'nullable',
                        'decimal:0,2',
                        'gte:' . $this->child_price_cost[$index],
                    ];
                }

                return [
                    'required',
                ];
            }),
            'child_weight.*' => 'nullable|decimal:0,3|min:0.01',
            'child_width.*' => 'nullable|integer|min:1',
            'child_height.*' => 'nullable|integer|min:1',
            'child_depth.*' => 'nullable|integer|min:1',
            'child_stock.*' => 'nullable|integer|min:0',
            'child_promo_value.*' => Rule::forEach(function ($value, $attribute) {
                $index = substr($attribute, strpos($attribute, '.') + 1);
                if (isset($this->child_price_cost) && isset($this->child_price_cost[$index])) {
                    return [
                        'nullable',
                        'decimal:0,2',
                        'gte:' . $this->child_price_cost[$index],
                    ];
                }

                return [
                    'required',
                ];
            }),
            'child_filename.*' => Rule::forEach(function ($value, $attribute) {
                return 'nullable|image|max:5120';
            }),
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
        // dump($this);
        $childPriceCosts = null;
        if ($this->has('child_price_cost')) {
            $childPriceCosts = [];
            foreach ($this->child_price_cost as $price_cost) {
                $childPriceCosts[] = str_replace('R$ ', '', str_replace(',', '.', $price_cost));
            }
        }

        $childPrices = null;
        if ($this->has('child_price')) {
            $childPrices = [];
            foreach ($this->child_price as $price) {
                $childPrices[] = str_replace('R$ ', '', str_replace(',', '.', $price));
            }
        }

        $childWeights = null;
        if ($this->has('child_weight')) {
            $childWeights = [];
            foreach ($this->child_weight as $weight) {
                $childWeights[] = str_replace(',', '.', $weight);
            }
        }

        $childWidths = null;
        if ($this->has('child_width')) {
            $childWidths = [];
            foreach ($this->child_width as $width) {
                $childWidths[] = $width;
            }
        }

        $childHeights = null;
        if ($this->has('child_height')) {
            $childHeights = [];
            foreach ($this->child_height as $height) {
                $childHeights[] = $height;
            }
        }

        $childDepths = null;
        if ($this->has('child_depth')) {
            $childDepths = [];
            foreach ($this->child_depth as $depth) {
                $childDepths[] = $depth;
            }
        }

        $childPromo_values = null;
        if ($this->has('child_promo_value')) {
            $childPromo_values = [];
            foreach ($this->child_promo_value as $promo_value) {
                $childPromo_values[] = str_replace('R$ ', '', str_replace(',', '.', $promo_value));
            }
        }

        $this->merge([
            'child_price_cost' => $childPriceCosts,
            'child_price' => $childPrices,
            'child_weight' => $childWeights,
            'child_width' => $childWidths,
            'child_height' => $childHeights,
            'child_depth' => $childDepths,
            'child_promo_value' => $childPromo_values,
        ]);
    }
}
