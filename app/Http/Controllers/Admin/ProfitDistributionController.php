<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProfitDistribution;
use App\Http\Controllers\Controller;
use App\Services\ProfitDistributionService;

class ProfitDistributionController extends Controller
{
    
    public function index(Request $request)
    {
        $year = $request->year ?? now()->year;

        return view('admin.profits.index', [
            'year' => $year,
            'profits' => ProfitDistribution::with('user')
                ->where('year', $year)
                ->get(),
        ]);
    }

    public function distribute(
        Request $request,
        ProfitDistributionService $service
    ) {
        $request->validate([
            'year' => ['required', 'integer'],
        ]);

        $service->distribute($request->year, $request->user());

        return back()->with('status', 'Profit distributed successfully.');
    }
}
