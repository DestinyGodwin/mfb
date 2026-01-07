<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'principal',
        'interest_rate',
        'duration_years',
        'total_payable',
        'status',
        'approved_by',
        'approved_at'
    ];

     protected $casts = [
        'approved_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
