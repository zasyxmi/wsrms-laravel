<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRepairRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'customer';
    }

    public function rules(): array
    {
        return [
            'device_type' => ['required', 'string', Rule::in(['Handphone', 'Laptop', 'PC'])],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'issue_description' => ['required', 'string', 'min:10'],
            'preferred_contact_method' => ['required', 'string', 'in:WhatsApp,Email,Phone Call'],
        ];
    }
}
