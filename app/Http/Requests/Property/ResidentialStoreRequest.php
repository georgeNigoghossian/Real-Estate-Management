<?php

namespace App\Http\Requests\Property;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResidentialStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'area' => ['numeric'],
            'tags' => ['nullable', 'array', 'exists:tags,id'],
            'amenities' => ['nullable', 'array', 'exists:amenities,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['string'],
            'latitude' => ['numeric', 'between:-90,90'],
            'longitude' => ['numeric', 'between:-180,180'],
            'status' => [Rule::in(array_column(StatusEnum::cases(), 'name'))],
            'num_of_bedrooms' => ['required','integer', 'min:1'],
            'num_of_bathrooms' => ['required','integer', 'min:1'],
            'num_of_balconies' => ['required','integer', 'min:0'],
            'num_of_living_rooms' => ['required','integer'],
            'floor' => ['integer'],
            'specialAttributes' => ['json']

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
