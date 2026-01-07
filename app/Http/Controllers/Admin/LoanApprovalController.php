<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Services\LoanService;
use App\Http\Controllers\Controller;

class LoanApprovalController extends Controller
{

    public function index()
    {
        $loans = Loan::where('status', 'pending')->with('user')->get();

        return view('admin.loans.pending', compact('loans'));
    }

    public function approve(Loan $loan, LoanService $service)
    {
        $service->approve($loan, request()->user());

        return back()->with('status', 'Loan approved.');
    }
}
