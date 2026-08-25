<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReplyContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'greeting' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
            'action_text' => ['nullable', 'string', 'max:255'],
            'action_url' => ['nullable', 'url', 'max:255'],
            'end_line' => ['nullable', 'string', 'max:255'],
        ];
    }
}
