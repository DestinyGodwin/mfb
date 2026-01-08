<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'date_of_birth'  => 'required|date',
            'sex'            => 'required|in:male,female',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'place_of_work'  => 'nullable|string|max:255',
            'department'     => 'nullable|string|max:255',
        ]);

        $request->user()->update($data);

        return back()->with('status', 'profile-updated');
    }

    public function updateBankAccount(Request $request)
    {
        $data = $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
        ]);

        BankAccount::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return back()->with('status', 'bank-account-updated');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
