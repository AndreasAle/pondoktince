<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'whatsapp_number' => ['required', 'string', 'max:25', 'regex:/^[0-9+\-\s]{8,25}$/'],
            'date' => ['nullable', 'date', 'after_or_equal:today'],
            'time' => ['nullable', 'string', 'max:20'],
            'people_count' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'purpose' => ['nullable', 'string', 'max:100'],
            'brand_key' => ['nullable', 'in:pondok-tince,pempek-tince'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'source_page' => ['nullable', 'string', 'max:255'],
            // Honeypot: must stay empty.
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'whatsapp_number.regex' => 'Nomor WhatsApp tidak valid.',
            'date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'website.prohibited' => 'Terjadi kesalahan. Silakan coba lagi.',
        ];
    }
}
