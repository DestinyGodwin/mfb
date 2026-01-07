<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ContributionService;
use App\Http\Requests\Admin\StoreContributionRequest;

class ContributionController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Contribution::with(['member', 'recorder'])
    //         ->latest('contribution_date');

    //     if ($request->filled(['from', 'to'])) {
    //         $query->whereBetween('contribution_date', [
    //             $request->date('from'),
    //             $request->date('to'),
    //         ]);
    //     }

    //     if ($request->filled('user_id')) {
    //         $query->where('user_id', $request->user_id);
    //     }

    //     return view('admin.contributions.index', [
    //         'contributions' => $query->paginate(20),
    //         'total' => (clone $query)->sum('amount'),
    //         'members' => User::approved()->get(),
    //     ]);
    // }

    public function index(Request $request)
{
    $query = Contribution::with(['member', 'recorder'])
        ->latest('contribution_date');

    if ($request->filled(['from', 'to'])) {
        $query->whereBetween('contribution_date', [
            $request->date('from'),
            $request->date('to'),
        ]);
    }

    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    return view('admin.contributions.index', [
        'contributions' => $query->paginate(20)->withQueryString(),
        'members' => User::approved()->get(),
        'year' => now()->year,
        'yearTotal' => Contribution::whereYear('contribution_date', now()->year)->sum('amount'),
    ]);
}


    public function create()
    {
        return view('admin.contributions.create', [
            'users' => User::approved()->get(),
        ]);
    }

    public function store(
        StoreContributionRequest $request,
        ContributionService $service
    ) {
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
}
