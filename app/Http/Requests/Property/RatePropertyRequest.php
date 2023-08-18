<?php

namespace App\Http\Requests\Property;

use App\Models\Property\Property;
use App\Models\User;
use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Http\FormRequest;

class RatePropertyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'review' => ['sometimes', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return PropertyPolicy::rate();
    }
}
