<?php

namespace App\Http\Requests\Admin;

use App\Helpers\DefaultStatus;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UserAdminRequest extends FormRequest {
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
            'status' => ['required', new Enum(DefaultStatus::class)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique(User::class, 'email')->ignore($this->user?->id)->withoutTrashed()],
            'password' => ['sometimes', 'confirmed', Password::min(8)],
        ];
    }
}
