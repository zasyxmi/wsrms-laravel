<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTechnicianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'specialization' => ['required', 'string', Rule::in(['Handphone', 'Laptop', 'PC'])],
            'availability_status' => ['required', 'string', 'in:available,busy,on_leave'],
        ];
    }
}
