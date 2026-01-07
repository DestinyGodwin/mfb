<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use App\Models\User;
use App\Services\LoanService;
use App\Services\InterestRateService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    protected InterestRateService $interestRateService;

    public function __construct(InterestRateService $interestRateService)
    {
        $this->interestRateService = $interestRateService;
    }

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
        'duration_years' => 'required|numeric|min:1',
    ]);

    $interestRate = $this->interestRateService->active();
    if (!$interestRate) {
        return back()->withErrors(['interest_rate' => 'No active interest rate found. Please set one first.']);
    }

    $data = [
        'user_id' => $request->user_id,
        'principal' => $request->principal,
        'interest_rate' => $interestRate->rate,
        'duration_years' => $request->duration_years,
        'recorded_by' => $request->user()->id,
    ];

    // Use admin method — auto approved
    $service->createByAdmin($data, $request->user());

    return redirect()->route('admin.loans.index')
        ->with('status', 'Loan created and approved successfully.');
}



    public function approve(Loan $loan, LoanService $service)
    {
        $service->approve($loan, request()->user());

        return back()->with('status', 'Loan approved.');
    }
}
