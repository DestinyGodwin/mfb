<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Loan\RequestLoanRequest;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Auth::user()->loans()->latest()->get();

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
