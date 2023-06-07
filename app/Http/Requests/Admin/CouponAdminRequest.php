<?php

namespace App\Http\Requests\Admin;

use App\Helpers\CouponDiscountTypes;
use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CouponAdminRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        // dd($this->all());
        return [
            //
            'status' => ['required', new Enum(DefaultStatus::class)],
            'token' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'discount_type' => ['required', new Enum(CouponDiscountTypes::class)],
            'discount' => 'required|decimal:0,2|min:0',
            'date_start' => 'nullable|date',
            'date_end' => ['nullable', 'date', ($this->filled('date_start') ? 'after:date_start' : '')],
            'qtd' => 'nullable|numeric',
            'value_min' => 'nullable|decimal:0,2|min:0',
            'value_max' => ['nullable', 'decimal:0,2', ($this->filled('value_min') ? 'gte:value_min' : '')],
            'first_buy' => [Rule::in([0, 1])],
        ];
    }

    public function messages(): array {
        return [
            'date_end.after' => 'A data de expiração deve ser maior que a data de início',
            'value_max.gt' => 'O valor máximo deve ser maior que o valor mínimo',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'discount' => str_replace(',', '.', $this->discount),
            'qtd' => $this->has('qtd') ? $this->qtd : null,
            'value_min' => $this->has('value_min') ? str_replace(',', '.', $this->value_min) : null,
            'value_max' => $this->has('value_max') ? str_replace(',', '.', $this->value_max) : null,
            'date_start' => $this->has('date_start') ? $this->date_start : null,
            'date_end' => $this->has('date_end') ? $this->date_end : null,
            'first_buy' => $this->has('first_buy') ? 1 : 0,
        ]);
    }
}
