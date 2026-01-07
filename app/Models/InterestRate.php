<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InterestRate extends Model
{
    use HasUuids;
    
    protected $fillable = ['rate', 'active'];
    
    protected $casts = [
        'rate' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}