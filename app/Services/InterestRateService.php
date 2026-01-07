<?php

namespace App\Services;

use App\Models\InterestRate;

class InterestRateService
{
    /**
     * Create a new class instance.
     */
     public function active(): ?InterestRate
    {
        return InterestRate::where('active', true)->first();
    }
}
