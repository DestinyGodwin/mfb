<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Contribution;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Members
        $totalMembers = User::count();
        $pendingMembers = User::where('approved', false)->count();

        // Loans
        $totalLoans = Loan::count();
        $pendingLoans = Loan::where('status', 'pending')->count();
        $totalLoanAmount = Loan::sum('total_payable');

        // Contributions
        $totalThisYear = Contribution::whereYear('contribution_date', now()->year)->sum('amount');

        return view('admin.dashboard', compact(
            'totalMembers',
            'pendingMembers',
            'totalLoans',
            'pendingLoans',
            'totalLoanAmount',
            'totalThisYear'
        ));
    }
}
