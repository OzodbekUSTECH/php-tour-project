<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourRequest extends FormRequest
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
            'user_id' => 'integer',
            'hotels_id' => 'array',
            'hotels_id.*' => 'integer',
            'types_id' => 'array',
            'types_id.*' => 'integer',
            'images' => 'array',
            'images.*' => 'image',
            'delete_media_ids' => 'array',
            'delete_media_ids.*' => 'integer',
            'days' => 'array',
            // 'days.*.*' => 'array',
            // 'days.*.*.*' => 'string',
            // 'delete_days_ids' => 'array',
        ];
    }
}
