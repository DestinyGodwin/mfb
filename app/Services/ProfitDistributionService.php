<?php

namespace App\Services;

use App\Models\User;
use App\Models\ProfitRate;
use App\Models\Contribution;
use App\Models\ProfitDistribution;
use Illuminate\Support\Facades\DB;

class ProfitDistributionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

     public function distribute(int $year, User $admin): void
    {
        $rate = ProfitRate::where('year', $year)
            ->where('active', true)
            ->firstOrFail();

        DB::transaction(function () use ($year, $rate) {

            $users = User::approved()->get();

            foreach ($users as $user) {
                $total = Contribution::where('user_id', $user->id)
                    ->whereYear('contribution_date', $year)
                    ->sum('amount');

                if ($total <= 0) {
                    continue;
                }

                $profit = $total * ($rate->percentage / 100);

                ProfitDistribution::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'year' => $year,
                    ],
                    [
                        'total_contribution' => $total,
                        'profit_amount' => $profit,
                        'distributed_at' => now(),
                    ]
                );
            }
        });
    }
}
