<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'nullable|email',
            'name' => 'nullable|string',
            'image' => 'nullable|image',
            'password' => 'nullable|confirmed|string',
            'is_owner' => 'nullable|boolean',
            'is_admin' => 'nullable|boolean',
        ];
    }
}
