<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\EngagementLog;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle the login attempt.
     */
    public function store(Request $request): RedirectResponse
{
      // Validate basic login credentials
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    $user = Auth::user();

    // Check if the user's account is deactivated
    if (!$user->is_active) {
        Auth::logout();
        
        return back()->withErrors([
            'email' => 'Your account has been deactivated. Please contact the administrator.',
        ])->withInput($request->only('email'));
    }

    $request->session()->regenerate();

         // Log successful login
        EngagementLog::create([
            'user_id' => $user->id,
            'subject_id' => null,
            'action' => 'login',
            'context' => 'login_success',
            'value' => 1,
        ]);

    // Check if user needs to change password (not admin and first_login = true)
    if ($user->first_login && $user->role !== 'admin') {
        // Clear any intended URL to prevent bypass
        $request->session()->forget('url.intended');
        
        return redirect()->route('change-password.edit')
            ->with('info', 'Welcome! Please change your default password to secure your account.');
    }

    // For normal users or after password change, redirect to intended page or dashboard
    return redirect()->intended(route('dashboard'));
}

    /**
     * Logout the user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}