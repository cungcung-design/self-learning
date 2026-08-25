<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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

    protected function failedValidation(Validator $validator): void
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo(route('home.public'));
    }
}
