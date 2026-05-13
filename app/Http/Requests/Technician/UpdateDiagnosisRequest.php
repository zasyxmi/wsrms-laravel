<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiagnosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'technician';
    }

    public function rules(): array
    {
        return [
            'diagnosis_result' => ['required', 'string', 'max:255'],
            'repair_notes' => ['nullable', 'string', 'max:1000'],
            'status' => [
                'required',
                'string',
                'in:under_diagnosis,in_repair,waiting_for_parts,unable_to_repair',
            ],
        ];
    }
}