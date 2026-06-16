<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersProfileController extends Controller
{
    public function show()
    {
        $user = User::with('role')->find(Auth::id());

        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'state' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'          => ['required', 'string'],
            'password'                  => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation'     => ['required', 'string'],
        ]);

        $user = User::find(Auth::id());

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'The current password you entered is incorrect.'])
                ->withInput();
        }

        $user->update(['password' => $request->password]);

        return back()->with('password_success', 'Password updated successfully.');
    }
}
