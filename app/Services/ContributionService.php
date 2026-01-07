<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contribution;


class ContributionService
{
    /**
     * Create a new class instance.
     */

     public function record(
        User $member,
        int|float $amount,
        Carbon $date,
        User $admin
    ): Contribution {
        return Contribution::create([
            'user_id' => $member->id,
            'amount' => $amount,
            'contribution_date' => $date,
            'recorded_by' => $admin->id,
        ]);
    }

    public function totalForYear(int $year): float
    {
        return Contribution::whereYear('contribution_date', $year)->sum('amount');
    }

    public function totalForRange(Carbon $from, Carbon $to): float
    {
        return Contribution::whereBetween('contribution_date', [$from, $to])
            ->sum('amount');
    }

    public function totalForMember(User $user): float
    {
        return Contribution::where('user_id', $user->id)->sum('amount');
    }

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
