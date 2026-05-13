<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SparePart extends Model
{
    protected $fillable = [
        'part_name',
        'category',
        'unit_price',
        'stock_quantity',
    ];

    public function repairSpareParts(): HasMany
    {
        return $this->hasMany(RepairSparePart::class);
    }
}