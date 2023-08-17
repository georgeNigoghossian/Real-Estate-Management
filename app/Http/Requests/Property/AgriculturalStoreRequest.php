<?php

namespace App\Http\Requests\Property;

use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Contract\Auth;

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
            'water_sources'=> ['integer','min:0'],
            'latitude' => ['numeric', 'between:-90,90'],
            'longitude' => ['numeric', 'between:-180,180'],
            'service' =>[Rule::in(array_column(ServiceEnum::cases(), 'name'))],
            'status' => [Rule::in(array_column(StatusEnum::cases(), 'name'))],
            'specialAttributes' => ['string'],
            'country' => ['integer', 'exists:countries,id'],
            'city' => ['integer', 'exists:cities,id'],
            'region' => ['string'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return PropertyPolicy::create();
    }
}
