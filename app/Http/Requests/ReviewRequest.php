<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "rating" => "required|numeric|min:0|max:5",
            "comment" => "nullable|string",
            "visited_on" => "required|date",
            "restaurant_id" => "required|exists:restaurants,id"
        ];
    }
}
