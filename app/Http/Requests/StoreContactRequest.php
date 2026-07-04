<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'contact' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
            'source_page' => ['nullable', 'string', 'max:255'],
            'website' => ['prohibited'], // honeypot
        ];
    }

    public function messages(): array
    {
        return [
            'website.prohibited' => 'Terjadi kesalahan. Silakan coba lagi.',
        ];
    }
}
