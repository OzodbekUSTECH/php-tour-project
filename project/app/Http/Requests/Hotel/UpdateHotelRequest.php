<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
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
            'title' => 'array',
            'title.*' => 'string',
            'description' => 'array',
            'description.*' => 'string',
            'rating' => 'integer',
            'user_id' => 'integer',
            'images' => 'array',
            'images.*' => 'image',
            'delete_media_ids' => 'array',
            'delete_media_ids.*' => 'integer',
        ];
    }
}
