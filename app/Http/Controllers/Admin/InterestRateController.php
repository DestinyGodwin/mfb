<?php

namespace App\Http\Controllers\Admin;

use App\Models\InterestRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InterestRateController extends Controller
{
    public function index()
    {
        return view('admin.interest_rates.index', [
            'rates' => InterestRate::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rate' => ['required', 'numeric', 'min:0'],
        ]);

        InterestRate::where('active', true)->update(['active' => false]);

        InterestRate::create([
            'rate' => $data['rate'],
            'active' => true,
        ]);

        return back()->with('status', 'Interest rate updated');
    }
}
