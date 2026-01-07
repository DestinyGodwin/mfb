<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use App\Models\InterestRate;

class LoanService
{
    /**
     * Create a loan (pending) — for user requests
     */
    public function create(array $data): Loan
    {
        if (!isset($data['total_payable'])) {
            $data['total_payable'] = $this->calculateTotal(
                $data['principal'],
                $data['interest_rate'],
                $data['duration_years']
            );
        }

        return Loan::create([
            ...$data,
            'status' => $data['status'] ?? 'pending',
        ]);
    }

    /**
     * Create a loan by admin — auto approved
     */
    public function createByAdmin(array $data, User $admin): Loan
    {
        $data['total_payable'] = $this->calculateTotal(
            $data['principal'],
            $data['interest_rate'],
            $data['duration_years']
        );

        return Loan::create([
            ...$data,
            'status' => 'approved',
            'approved_by' => $admin->id,
            'approved_at' => now(),
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

    public function userLoans(string $userId)
    {
        return Loan::where('user_id', $userId)->latest()->get();
    }

    private function calculateTotal(float $principal, float $rate, int $years): float
    {
        return $principal + ($principal * ($rate / 100) * $years);
    }
}
