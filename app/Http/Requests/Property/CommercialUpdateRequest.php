<?php

namespace App\Http\Requests\Property;

use App\Enums\StatusEnum;
use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommercialUpdateRequest extends FormRequest
{

    public function prepareForValidation()
    {
        if($this->images){
            return 'oy';

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'images' => [],
            'name' => ['string', 'min:3', 'max:255'],
            'area' => ['numeric'],
            'tags' => ['nullable', 'array', 'exists:tags,id'],
            'amenities' => ['nullable', 'array', 'exists:amenities,id'],
            'price' => ['numeric', 'min:0'],
            'description' => ['string'],
            'latitude' => ['numeric', 'between:-90,90'],
            'longitude' => ['numeric', 'between:-180,180'],
            'status' => [Rule::in(array_column(StatusEnum::cases(), 'name'))],
            'num_of_bathrooms' => ['integer', 'min:1'],
            'num_of_balconies' => ['integer', 'min:0'],
            'floor' => ['nullable','integer'],
            'specialAttributes' => ['string']

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return PropertyPolicy::update($this->route()->commercial->property);
    }
}
