<?php

namespace Modules\Content\Http\Requests;

use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Content\Helpers\ContentNavTypes;

class AdminContentNavRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'status' => ['required', new Enum(DefaultStatus::class)],
            'title' => 'required|string|max:255',
            'type' => ['required', new Enum(ContentNavTypes::class)],
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
