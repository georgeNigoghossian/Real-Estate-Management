<?php

namespace App\Http\Requests\Property;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgriculturalStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'images' => ['required', 'min:3'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'area' => ['numeric'],
            'tags' => ['nullable', 'array', 'exists:tags,id'],
            'amenities' => ['nullable', 'array', 'exists:amenities,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['string'],
            'latitude' => ['numeric', 'between:-90,90'],
            'longitude' => ['numeric', 'between:-180,180'],
            'status' => [Rule::in(array_column(StatusEnum::cases(), 'name'))],
            'specialAttributes' => ['string'],
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
