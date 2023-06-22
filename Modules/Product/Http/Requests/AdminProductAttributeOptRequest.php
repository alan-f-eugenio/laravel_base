<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductAttributeOptRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'option_ordem.*' => 'required|numeric',
            'option_id.*' => 'nullable|numeric',
            'option_name.*' => 'required|string|max:255',
            'option_filename.*' => 'sometimes|image|max:5120',
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
}
