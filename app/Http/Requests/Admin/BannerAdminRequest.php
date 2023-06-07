<?php

namespace App\Http\Requests\Admin;

use App\Helpers\DefaultStatus;
use App\Models\Banner;
use App\Models\BannerLocal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BannerAdminRequest extends FormRequest {
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
            //
            'status' => ['required', new Enum(DefaultStatus::class)],
            'local_id' => ['required', Rule::exists(BannerLocal::class, 'id')],
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'ordem' => 'required|integer',
            'filename' => 'sometimes|image|max:5120',
        ];
    }

    protected function prepareForValidation() {
        if (!$this->has('ordem')) {
            $lastBanner = Banner::where('local_id', $this->local_id)->latest()->first();
            $this->merge([
                'ordem' => $lastBanner ? $lastBanner->ordem + 1 : 1,
            ]);
        }
    }
}
