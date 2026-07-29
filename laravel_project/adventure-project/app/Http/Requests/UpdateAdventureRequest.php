<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdventureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'difficulty' => 'nullable|string|max:50',
            'duration' => 'nullable|string|max:50',
            'max_people' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_maps_url' => 'nullable|url',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
