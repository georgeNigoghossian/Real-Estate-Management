<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class reportClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'string'],
            'reported_user_id' => ['required', 'exists:users,id'],
            'report_category_id' => ['required', 'exists:report_categories,id'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->reported_user_id != auth()->user()->id;
    }
}
