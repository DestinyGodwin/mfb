<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContributionRequest;
use App\Models\Contribution;
use App\Models\User;
use App\Services\ContributionService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContributionsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->filteredQuery($request);

        $contributions = $query->paginate(20)->withQueryString();

        $totalAmount = $query->sum('amount');
        $selectedMemberNames = $this->getSelectedMemberNames($request);

        return view('admin.contributions.index', [
            'contributions' => $contributions,
            'members' => User::approved()->get(),
            'totalAmount' => $totalAmount,
            'selectedMemberNames' => $selectedMemberNames,
        ]);
    }

    public function create()
    {
        return view('admin.contributions.create', [
            'users' => User::approved()->get(),
        ]);
    }

    public function store(StoreContributionRequest $request, ContributionService $service)
    {
        $service->record(
            User::findOrFail($request->user_id),
            $request->amount,
            $request->date('contribution_date'),
            $request->user()
        );

        return redirect()
            ->route('admin.contributions.index')
            ->with('status', 'Contribution recorded.');
    }

    private function filteredQuery(Request $request)
    {
        $query = Contribution::with(['member', 'recorder'])->latest('contribution_date');

        if ($request->filled(['from', 'to'])) {
            $query->whereBetween('contribution_date', [$request->from, $request->to]);
        }

        if ($request->filled('user_ids')) {
            $query->whereIn('user_id', $request->user_ids);
        }

        return $query;
    }

    private function getSelectedMemberNames(Request $request)
    {
        if (empty($request->user_ids)) return 'All Members';

        return User::whereIn('id', $request->user_ids)
            ->get()
            ->map(fn ($u) => $u->first_name.' '.$u->last_name)
            ->join(', ');
    }

    // Excel Export
    public function exportExcel(Request $request)
    {
        $fileName = $this->getExportFileName($request, 'contributions') . '.xlsx';
        return Excel::download(new ContributionsExport($request), $fileName);
    }

    // PDF Export
    public function exportPdf(Request $request)
    {
        $contributions = $this->filteredQuery($request)->get();
        $selectedMembers = $this->getSelectedMemberNames($request);
        $totalAmount = $contributions->sum('amount');

        $pdf = Pdf::loadView('admin.contributions.export-pdf', [
            'contributions' => $contributions,
            'totalAmount' => $totalAmount,
            'selectedMembers' => $selectedMembers,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        return $pdf->download($this->getExportFileName($request, 'contributions') . '.pdf');
    }

    private function getExportFileName(Request $request, $prefix)
    {
        $members = $this->getSelectedMemberNames($request);
        $from = $request->from ?? 'start';
        $to = $request->to ?? 'end';
        return "{$prefix}_{$members}_{$from}_to_{$to}";
    }
}
