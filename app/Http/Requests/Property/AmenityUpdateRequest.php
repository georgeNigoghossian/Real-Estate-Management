<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class AmenityUpdateRequest extends FormRequest
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
            'active' => ['sometimes','boolean'],
            'description' => ['sometimes', 'numeric','min:0'],
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
