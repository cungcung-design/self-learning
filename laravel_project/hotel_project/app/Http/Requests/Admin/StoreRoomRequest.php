<?php

namespace App\Http\Requests\Admin;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'hotel_id' => ['nullable', 'integer', 'exists:hotels,id'],
            'room_name' => ['required', 'string', 'max:255'],
            'room_description' => ['nullable', 'string'],
            'room_price' => ['required', 'numeric', 'min:0'],
            'room_wifi' => ['required', Rule::in(['yes', 'no'])],
            'room_type' => ['required', Rule::in(Room::TYPES)],
            'room_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'room_images' => ['nullable', 'array', 'max:10'],
            'room_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'max_guests' => ['nullable', 'integer', 'min:1'],
            'beds' => ['nullable', 'integer', 'min:1'],
            'bed_type' => ['nullable', 'string', 'max:255'],
            'room_size' => ['nullable', 'string', 'max:255'],
            'is_available' => ['nullable', 'boolean'],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('room_type')) {
            $this->merge([
                'room_type' => strtolower((string) $this->input('room_type')),
            ]);
        }
    }
}
