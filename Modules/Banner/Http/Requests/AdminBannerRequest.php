<?php

namespace Modules\Banner\Http\Requests;

use App\Helpers\DefaultStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Entities\BannerLocal;

class AdminBannerRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'status' => ['required', new Enum(DefaultStatus::class)],
            'local_id' => ['required', Rule::exists(BannerLocal::class, 'id')],
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'ordem' => 'required|integer',
            'filename' => 'sometimes|image|max:5120',
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

    protected function prepareForValidation() {
        if (!$this->has('ordem')) {
            $lastBanner = Banner::where('local_id', $this->local_id)->orderBy('ordem', 'desc')->first();
            $this->merge([
                'ordem' => $lastBanner ? $lastBanner->ordem + 1 : 1,
            ]);
        }
    }
}
