<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ContributionService;
use App\Http\Requests\Admin\StoreContributionRequest;

class ContributionController extends Controller
{
    public function create()
    {
        $users = User::where('approved', true)->get();

        return view('admin.contributions.create', compact('users'));
    }

    public function store(
        StoreContributionRequest $request,
        ContributionService $service
    ) {
        $service->create(
            User::findOrFail($request->user_id),
            $request->amount,
            $request->contribution_date,
            $request->user()
        );

        return back()->with('status', 'Contribution recorded successfully.');
    }
}
