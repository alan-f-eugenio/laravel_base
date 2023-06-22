<?php

namespace Modules\Customer\Http\Requests;

use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Helpers\CustomerPersons;

class AdminCustomerRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'status' => ['required', new Enum(DefaultStatus::class)],
            'person' => ['required', new Enum(CustomerPersons::class)],
            'fullname' => 'required|string|max:255',
            'cpf' => ['required', 'formato_cpf', 'cpf', Rule::unique(Customer::class, 'cpf')->ignore($this->customer?->id)->withoutTrashed()],
            'rg' => ['nullable', 'string', 'max:255', Rule::unique(Customer::class, 'rg')->ignore($this->customer?->id)->withoutTrashed()],
            'date_birth' => ['required', 'date',  'before:-18 years'],
            'cnpj' => ['sometimes', 'formato_cnpj', 'cnpj', Rule::unique(Customer::class, 'cnpj')->ignore($this->customer?->id)->withoutTrashed()],
            'corporate_name' => ['sometimes', 'string', 'max:255', Rule::unique(Customer::class, 'corporate_name')->ignore($this->customer?->id)->withoutTrashed()],
            'state_registration' => ['sometimes', 'string', 'max:255', Rule::unique(Customer::class, 'state_registration')->ignore($this->customer?->id)->withoutTrashed()],
            'email' => ['required', 'email', Rule::unique(Customer::class, 'email')->ignore($this->customer?->id)->withoutTrashed()],
            'phone' => 'required|celular_com_ddd',
            'password' => ['sometimes', 'confirmed', Password::min(8)],
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
