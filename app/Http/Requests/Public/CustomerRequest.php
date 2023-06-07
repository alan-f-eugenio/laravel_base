<?php

namespace App\Http\Requests\Public;

use App\Helpers\CustomerPersons;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class CustomerRequest extends FormRequest {
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
            'person' => ['required', new Enum(CustomerPersons::class)],
            'fullname' => 'required|string|max:255',
            'cpf' => ['required', 'formato_cpf', 'cpf', Rule::unique(Customer::class, 'cpf')->ignore(auth()->id())->withoutTrashed()],
            'rg' => ['nullable', 'string', 'max:255', Rule::unique(Customer::class, 'rg')->ignore(auth()->id())->withoutTrashed()],
            'date_birth' => ['required', 'date',  'before:-18 years'],
            'cnpj' => ['sometimes', 'formato_cnpj', 'cnpj', Rule::unique(Customer::class, 'cnpj')->ignore(auth()->id())->withoutTrashed()],
            'corporate_name' => ['sometimes', 'string', 'max:255', Rule::unique(Customer::class, 'corporate_name')->ignore(auth()->id())->withoutTrashed()],
            'state_registration' => ['sometimes', 'string', 'max:255', Rule::unique(Customer::class, 'state_registration')->ignore(auth()->id())->withoutTrashed()],
            'email' => ['required', 'email', Rule::unique(Customer::class, 'email')->ignore(auth()->id())->withoutTrashed()],
            'phone' => 'required|celular_com_ddd',
            'password' => ['sometimes', 'confirmed', Password::min(8)],
        ];
    }
}
