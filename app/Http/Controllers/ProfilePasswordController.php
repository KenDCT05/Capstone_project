<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfilePasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ])->withInput();
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect to dashboard with success message
        return redirect()->route('dashboard')->with('success', 'Password updated successfully!');
    }
}