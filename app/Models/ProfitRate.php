<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProfitRate extends Model
{
   use HasUuids;

    protected $fillable = [
        'year',
        'percentage',
        'active',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'active' => 'boolean',
    ];
}
