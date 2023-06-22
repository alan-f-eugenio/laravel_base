<?php

namespace Modules\Content\Http\Requests;

use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AdminContentRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'status' => ['required', new Enum(DefaultStatus::class)],
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'page_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'abstract' => 'nullable|string',
            'filename' => 'nullable|image|max:5120',
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
