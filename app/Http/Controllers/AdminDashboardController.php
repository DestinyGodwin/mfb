<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\ProfitRate;
use App\Models\Contribution;
use App\Models\ProfitDistribution;

class AdminDashboardController extends Controller
{
    // public function index()
    // {
    //     // Members
    //     $totalMembers = User::count();
    //     $pendingMembers = User::where('approved', false)->count();

    //     // Loans
    //     $totalLoans = Loan::count();
    //     $pendingLoans = Loan::where('status', 'pending')->count();
    //     $totalLoanAmount = Loan::sum('total_payable');

    //     // Contributions
    //     $totalThisYear = Contribution::whereYear('contribution_date', now()->year)->sum('amount');

    //     return view('admin.dashboard', compact(
    //         'totalMembers',
    //         'pendingMembers',
    //         'totalLoans',
    //         'pendingLoans',
    //         'totalLoanAmount',
    //         'totalThisYear'
    //     ));
    // }

       public function index()
    {
        $year = now()->year;

        $totalMembers = User::count();
        $pendingMembers = User::where('status', 'pending')->count();

        $totalLoans = Loan::count();
        $pendingLoans = Loan::where('status', 'pending')->count();
        $totalLoanAmount = Loan::sum('principal');

        $totalThisYear = Contribution::whereYear('contribution_date', $year)->sum('amount');

        $profitRate = ProfitRate::where('year', $year)
            ->where('active', true)
            ->first();

        $totalProfitDistributed = ProfitDistribution::where('year', $year)
            ->sum('profit_amount');

        $profitDistributed = ProfitDistribution::where('year', $year)->exists();

        return view('admin.dashboard', compact(
            'year',
            'totalMembers',
            'pendingMembers',
            'totalLoans',
            'pendingLoans',
            'totalLoanAmount',
            'totalThisYear',
            'profitRate',
            'totalProfitDistributed',
            'profitDistributed'
        ));
    }
}
