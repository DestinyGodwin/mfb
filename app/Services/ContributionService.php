<?php

namespace App\Services;

use App\Models\User;
use App\Models\Contribution;


class ContributionService
{
    /**
     * Create a new class instance.
     */
    public function yearlyTotalForUser(string $userId, ?int $year = null): float
    {
        $year ??= now()->year;

        return Contribution::where('user_id', $userId)
            ->whereYear('contribution_date', $year)
            ->sum('amount');
    }

    public function create(User $user, float $amount, string $date, User $admin): Contribution
    {
        return Contribution::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'contribution_date' => $date,
            'recorded_by' => $admin->id,
        ]);
    }
}
