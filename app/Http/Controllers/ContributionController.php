<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index()
    {
        $contributions = auth()->user()
            ->contributions()
            ->latest('contribution_date')
            ->get();

        return view('contributions.index', compact('contributions'));
    }
}
