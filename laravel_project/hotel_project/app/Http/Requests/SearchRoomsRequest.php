<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRoomsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after:start_date', 'required_with:start_date'],
            'room_type' => ['nullable', Rule::in(Room::TYPES)],
        ];
    }

    public function hasDateRange(): bool
    {
        return $this->filled('start_date')
            && $this->filled('end_date')
            && $this->date('end_date')?->gt($this->date('start_date'));
    }
}
