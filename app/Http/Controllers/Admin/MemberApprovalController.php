<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberApprovalController extends Controller
{
     public function index()
    {
        // $this->authorize('approve-members');

        $users = User::where('approved', false)->get();

        return view('admin.members.pending', compact('users'));
    }

    public function approve(User $user)
    {
        // $this->authorize('approve-members');

        $user->update(['approved' => true]);

        return back()->with('status','Member approved successfully');
    }

    public function reject(User $user)
    {
        // $this->authorize('approve-members');
        $user->delete();
        return back()->with('status','Member rejected and deleted');
    }
}
