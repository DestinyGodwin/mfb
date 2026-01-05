<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InterestRate extends Model
{
    use HasUuids; 
    protected $fillable = ['rate', 'active'];
    

}
