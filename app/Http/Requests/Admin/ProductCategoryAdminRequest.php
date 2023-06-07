<?php

namespace App\Http\Requests\Admin;

use App\Helpers\DefaultStatus;
use App\Http\Controllers\Admin\ProductCategoryController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProductCategoryAdminRequest extends FormRequest {
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
        return [
            //
            'status' => ['required', new Enum(DefaultStatus::class)],
            'id_parent' => ['nullable', $this->product_category ? Rule::notIn(ProductCategoryController::recursiveCategoryChild($this->product_category, [])) : ''],
            'name' => 'required|string|max:255',
            'page_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'filename' => 'sometimes|image|max:5120',
        ];
    }

    public function messages(): array {
        return [
            'id_parent' => 'Categoria Pai inválida',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'id_parent' => $this->id_parent ?: null,
        ]);
    }
}
