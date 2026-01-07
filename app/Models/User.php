<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'sex',
        'phone',
        'address',
        'place_of_work',
        'department',
        'status',
        'approved',
        'avatar',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class);
    }

     public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approved', true);
    }
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
    public function recordedContributions()
    {
        return $this->hasMany(Contribution::class, 'recorded_by');
    }
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class, 'performed_by');
    }

    public function isActive(): bool
    {
        return $this->approved && $this->status === 'active';
    }
}
