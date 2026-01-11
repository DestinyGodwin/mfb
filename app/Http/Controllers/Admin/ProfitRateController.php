<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProfitRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfitRateController extends Controller
{
     public function index()
    {
        return view('admin.profit-rates.index', [
            'rates' => ProfitRate::orderByDesc('year')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'unique:profit_rates,year'],
            'percentage' => ['required', 'numeric', 'min:0'],
        ]);

        ProfitRate::create([
            ...$data,
            'active' => false,
        ]);

        return back()->with('status', 'Profit rate created.');
    }

    public function activate(ProfitRate $profitRate)
    {
        ProfitRate::where('year', $profitRate->year)
            ->update(['active' => false]);

        $profitRate->update(['active' => true]);

        return back()->with('status', 'Profit rate activated.');
    }
}
