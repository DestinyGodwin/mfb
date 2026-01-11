<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProfitDistribution;
use App\Http\Controllers\Controller;
use App\Services\ProfitDistributionService;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProfitDistributionsExport;


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


    public function exportExcel(Request $request)
    {
        $year = $request->year ?? now()->year;
        return Excel::download(
            new ProfitDistributionsExport($year),
            "profit_distribution_{$year}.xlsx"
        );
    }
      public function exportPdf(Request $request)
    {
        $year = $request->year ?? now()->year;

        $profits = ProfitDistribution::with('user')
            ->where('year', $year)
            ->get();

        $totalProfit = $profits->sum('profit_amount');

        $pdf = Pdf::loadView('admin.profits.export-pdf', [
            'profits' => $profits,
            'year' => $year,
            'totalProfit' => $totalProfit,
        ]);

        return $pdf->download("profit_distribution_{$year}.pdf");
    }
}
