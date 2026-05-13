<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepairSparePartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'technician';
    }

    public function rules(): array
    {
        return [
            'spare_part_id' => ['required', 'exists:spare_parts,id'],
            'quantity_used' => ['required', 'integer', 'min:1'],
        ];
    }
}