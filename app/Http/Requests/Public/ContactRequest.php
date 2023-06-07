<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest {
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|celular_com_ddd|max:255',
            'message' => 'required|string',
        ];
    }
}
