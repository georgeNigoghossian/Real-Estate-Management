<?php

namespace App\Http\Requests\Agency;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromoteToAgencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required'],
            'longitude' => ['required'],
            'region_id' => ['required', 'exists:regions,id'],
//            'files' => ['required','min:1', 'mimes:jpeg,jpg,png,doc,docs,pdf'],
            'files' => ['required','min:1'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
