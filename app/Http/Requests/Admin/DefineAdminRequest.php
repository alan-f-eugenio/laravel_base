<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DefineAdminRequest extends FormRequest {
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
            'page_title' => 'required|string|max:255',
            'page_meta_keywords' => 'nullable|string|max:255',
            'page_meta_description' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_corporate_name' => 'required|string|max:255',
            'company_cnpj' => 'required|cnpj',
            'company_cep' => 'required|formato_cep',
            'company_address' => 'nullable|string',
            'company_opening_hours' => 'nullable|string|max:255',
            'company_email' => 'required|email',
            'company_phone' => 'nullable|celular_com_ddd',
            'company_whats' => 'nullable|celular_com_ddd',
            'company_face' => 'nullable|string|max:255',
            'company_insta' => 'nullable|string|max:255',
            'company_yout' => 'nullable|string|max:255',
        ];
    }
}
