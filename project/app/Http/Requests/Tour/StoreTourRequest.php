<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'string',
            'description' => 'required|array',
            'description.*' => 'string',
            'user_id' => 'required|integer',
            'images' => 'required|array',
            'images.*' => 'image',
            'hotels_id' => 'required|array',
            'hotels_id.*' => 'integer',
            'types_id' => 'required|array',
            'types_id.*' => 'integer',
            'days' => 'required|array',
            'url' => 'required|string',
            // 'days.*.' => 'array',
            // 'days.*.*.*' => 'string',
            // 'days.*.images' => 'required|array',
            // 'days.*.images.*' => 'image',
            'price' => 'required|decimal:2'
        ];
    }
}
