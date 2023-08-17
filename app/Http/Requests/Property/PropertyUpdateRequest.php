<?php

namespace App\Http\Requests\Property;

use App\Enums\StatusEnum;
use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:255'],
            'price' => ['sometimes', 'numeric','min:0'],
            'description' => ['string'],
            'status' => [Rule::in(array_column(StatusEnum::cases(), 'name'))],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return PropertyPolicy::update($this->route()->property);
    }
}
