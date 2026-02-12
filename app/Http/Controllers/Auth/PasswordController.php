<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Show the change password form.
     */
    public function edit(): View
    {
        return view('auth.change-password');
    }

    /**
     * Handle the password change request with proper validation.
     */
  public function update(Request $request): RedirectResponse
    {
        // Validate password with all requirements matching the UI
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',                    // At least 8 characters
                'regex:/[a-z]/',            // At least one lowercase letter
                'regex:/[A-Z]/',            // At least one uppercase letter
                'regex:/[0-9]/',            // At least one number
                'confirmed',                // Must match password_confirmation
            ],
            'password_confirmation' => 'required',
        ], [
            // Custom error messages
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your password.',
        ]);

        $user = Auth::user();
        
        // Store the original first_login status
        $wasFirstLogin = $user->first_login;
        
        // Update password
        $user->password = Hash::make($request->password);
        
        // Mark that user has changed password from default
        $user->first_login = false;
        
        $user->save();

        if ($wasFirstLogin) {
            // For first-time password change, keep user logged in and redirect to dashboard
            return redirect()->route('dashboard')
                ->with('success', 'Password changed successfully! Welcome to your dashboard.');
        } else {
            // For regular password changes, keep them on the change-password page with success message
            return back()->with('success', 'Password changed successfully!');
        }
    }
}