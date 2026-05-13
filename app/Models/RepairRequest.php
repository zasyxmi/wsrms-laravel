<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RepairRequest extends Model
{
    protected $fillable = [
        'repair_code',
        'customer_id',
        'device_id',
        'technician_id',
        'issue_description',
        'diagnosis_result',
        'repair_notes',
        'preferred_contact_method',
        'status',
        'request_date',
        'completed_date',
    ];

    protected $casts = [
        'request_date' => 'date',
        'completed_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    public function repairSpareParts(): HasMany
{
    return $this->hasMany(RepairSparePart::class);
}

public function invoice(): HasOne
{
    return $this->hasOne(Invoice::class);
}

}