<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
     public function edit()
    {
        return view('auth.change-password');
    }

    /**
     * Handle the password change request.
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->first_login = false; // mark as no longer first login
        $user->save();

        Auth::logout(); // force re-login

        return redirect('/login')->with('success', 'Password changed successfully. Please log in again.');
    }
}
