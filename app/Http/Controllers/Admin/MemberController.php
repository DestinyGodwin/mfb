<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = User::query()
            ->when($request->filled('approved'), fn($q) => $q->where('approved', $request->approved === '1'))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20|unique:users,phone',
        'date_of_birth' => 'required|date',
        'sex' => 'required|in:male,female',
        'address' => 'required|string|max:255',
        'department' => 'nullable|string|max:255',
        'place_of_work' => 'nullable|string|max:255',
    ]);


        // Automatically generate a random password
        $password = Str::random(10);

        $user = User::create([
            ...$data,
            'password' => Hash::make($password),
            'status' => 'active', // default
            'approved' => true,   // admin-created members are auto-approved
        ]);

          return redirect()
        ->route('admin.members.create')
        ->with('success', "Member created successfully!")
        ->with('temp_password', $password); // pass the temp password separately
}

    public function approve(User $user)
    {
        if ($user->approved) return back();

        $user->update(['approved' => true]);

        return back()->with('success', 'Member approved');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate(['status' => 'required|in:active,suspended,blocked']);

        if (! $user->approved) abort(403, 'Member must be approved first');

        $user->update(['status' => $request->status]);

        return back()->with('success', 'Member status updated');
    }

    public function show(User $user)
    {
        return view('admin.members.show', compact('user'));
    }
}
