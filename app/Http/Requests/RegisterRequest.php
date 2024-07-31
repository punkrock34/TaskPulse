<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'terms.accepted' => 'You must accept the terms and conditions.',
        ];
    }
}
