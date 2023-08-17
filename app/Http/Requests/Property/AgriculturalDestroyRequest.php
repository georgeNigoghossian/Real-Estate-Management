<?php

namespace App\Http\Requests\Property;

use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Http\FormRequest;

class AgriculturalDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return PropertyPolicy::delete($this->route()->agricultural->property);
    }
}
