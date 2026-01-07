<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{

    use HasUuids;
    protected $fillable = ['year', 'closed', 'closed_at', 'closed_by'];
    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
}
