<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LoanService;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('user');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $loans = $query->paginate(15);

        $totalLoans = Loan::count();
        $totalLoanAmount = Loan::sum('principal');
        $pendingLoans = Loan::where('status', 'pending')->count();
        $approvedLoans = Loan::where('status', 'approved')->count();
        $users = User::all();

        return view('admin.loans.index', compact(
            'loans',
            'totalLoans',
            'totalLoanAmount',
            'pendingLoans',
            'approvedLoans',
            'users'
        ));
    }

    public function create()
    {
        $users = User::where('approved', true)->get();
        return view('admin.loans.create', compact('users'));
    }

    public function store(Request $request, LoanService $service)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'principal' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'duration_years' => 'required|numeric|min:1',
        ]);

        $service->create(
            User::findOrFail($request->user_id),
            $request->principal,
            $request->interest_rate,
            $request->duration_years,
            $request->user()
        );

        return redirect()->route('admin.loans.index')
            ->with('status', 'Loan created successfully.');
    }

    public function approve(Loan $loan, LoanService $service)
    {
        $service->approve($loan, request()->user());

        return back()->with('status', 'Loan approved.');
    }
}
