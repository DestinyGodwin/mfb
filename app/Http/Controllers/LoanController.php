<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loan\RequestLoanRequest;
use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;

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


    public function store(RequestLoanRequest $request, LoanService $service)
    {
        $service->request(
            Auth::user(),
            $request->principal,
            $request->duration_years
        );

        return redirect()
            ->route('loans.index')
            ->with('status', 'Loan request submitted and awaiting approval');
    }
}
