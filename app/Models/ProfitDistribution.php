<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProfitDistribution extends Model
{
     use HasUuids;

    protected $fillable = [
        'user_id',
        'year',
        'total_contribution',
        'profit_amount',
        'distributed_at',
    ];

    protected $casts = [
        'distributed_at' => 'datetime',
        'total_contribution' => 'decimal:2',
        'profit_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
