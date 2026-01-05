<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    use HasUuids;

    protected $fillable = ['account_id', 'debit', 'credit', 'reference', 'performed_by'];
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function actor()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
