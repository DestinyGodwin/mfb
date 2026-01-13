<?php

namespace App\Http\Controllers;

use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;
use App\Services\InterestRateService;
use App\Http\Requests\Loan\RequestLoanRequest;

class LoanController extends Controller
{
    public function index()
{
    $loans = Auth::user()
        ->loans()
        ->latest()
        ->paginate(10);

    return view('loans.index', compact('loans'));
}


    
public function store(
    RequestLoanRequest $request,
    LoanService $loanService,
    InterestRateService $rateService
) {
    $rate = $rateService->active();

    abort_if(! $rate, 500, 'No active interest rate configured');

    $loanService->create([
        'user_id' => Auth::id(),
        'principal' => $request->principal,
        'duration_years' => $request->duration_years,
        'interest_rate' => $rate->rate,
    ]);

    return redirect()
        ->route('loans.index')
        ->with('status', 'Loan request submitted and awaiting approval');
}

}
