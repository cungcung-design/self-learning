<?php

namespace App\Http\Requests\Admin;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'room_name' => ['required', 'string', 'max:255'],
            'room_description' => ['nullable', 'string'],
            'room_price' => ['required', 'numeric', 'min:0'],
            'room_wifi' => ['required', Rule::in(['yes', 'no'])],
            'room_type' => ['required', Rule::in(Room::TYPES)],
            'room_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'room_images' => ['nullable', 'array', 'max:10'],
            'room_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'delete_image_ids' => ['nullable', 'array'],
            'delete_image_ids.*' => ['integer', 'exists:room_images,id'],
            'primary_image_id' => ['nullable', 'integer', 'exists:room_images,id'],
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
