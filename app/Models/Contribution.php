<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'amount',
        'recorded_by',
        'contribution_date',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
