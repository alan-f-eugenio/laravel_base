<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeOptAdminRequest extends FormRequest {
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
            'option_ordem.*' => 'required|numeric',
            'option_id.*' => 'nullable|numeric',
            'option_name.*' => 'required|string|max:255',
            'option_filename.*' => 'sometimes|image|max:5120',
        ];
    }
}
