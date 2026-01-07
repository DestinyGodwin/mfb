<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Contribution;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalLoanAmount = Loan::sum('total_payable');
        $pendingLoans = Loan::where('status', 'pending')->count();

        $totalThisYear = Contribution::whereYear('contribution_date', now()->year)->sum('amount');
        
        $totalMembers = User::count();
        $pendingMembers = User::where('approved', false)->count();

        return view('admin.dashboard', compact(
            'totalLoanAmount',
            'pendingLoans',
            'totalThisYear',
            'totalMembers',
            'pendingMembers'
        ));
    }
}
