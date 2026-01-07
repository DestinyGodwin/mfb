<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use App\Models\InterestRate;

class LoanService
{
    /**
     * Create a new class instance.
     */
    public function create(array $data): Loan
    {
        return Loan::create([
            ...$data,
            'status' => 'pending',
        ]);
    }

    public function userLoans(string $userId)
    {
        return Loan::where('user_id', $userId)->latest()->get();
    }

    public function request(User $user, float $principal, int $years): Loan
    {
        $rate = InterestRate::where('active', true)->firstOrFail();

        return Loan::create([
            'user_id' => $user->id,
            'principal' => $principal,
            'interest_rate' => $rate->rate,
            'duration_years' => $years,
            'total_payable' => $this->calculateTotal($principal, $rate->rate, $years),
            'status' => 'pending',
        ]);
    }

    public function approve(Loan $loan, User $admin): Loan
    {
        $loan->update([
            'status' => 'approved',
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        return $loan;
    }

    private function calculateTotal(float $principal, float $rate, int $years): float
    {
        return $principal + ($principal * ($rate / 100) * $years);
    }
}

