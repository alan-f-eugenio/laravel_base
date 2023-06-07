<?php

namespace App\Http\Requests\Admin;

use App\Helpers\ContentNavTypes;
use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ContentNavAdminRequest extends FormRequest {
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
            'status' => ['required', new Enum(DefaultStatus::class)],
            'title' => 'required|string|max:255',
            'type' => ['required', new Enum(ContentNavTypes::class)],
        ];
    }
}
