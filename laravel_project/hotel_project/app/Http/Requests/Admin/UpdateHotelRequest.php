<?php

namespace App\Http\Requests\Admin;

use App\Models\Hotel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('hotels', 'slug')->ignore($this->route('hotel'))],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_info' => ['nullable', 'string'],
            'check_in_time' => ['nullable', 'string', 'max:20'],
            'check_out_time' => ['nullable', 'string', 'max:20'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'hotel_images' => ['nullable', 'array', 'max:10'],
            'hotel_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'featured_category_ids' => ['nullable', 'array'],
            'featured_category_ids.*' => ['integer', 'exists:featured_categories,id'],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
            'delete_image_ids' => ['nullable', 'array'],
            'delete_image_ids.*' => ['integer', 'exists:hotel_images,id'],
            'primary_image_id' => ['nullable', 'integer', 'exists:hotel_images,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('status')) {
            $this->merge([
                'status' => $this->route('hotel')?->status ?? 'active',
            ]);
        }

        if ($this->has('slug')) {
            $this->merge([
                'slug' => strtolower(trim((string) $this->input('slug'))),
            ]);
        }
    }
}
