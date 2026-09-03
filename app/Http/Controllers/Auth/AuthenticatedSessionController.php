<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        ActivityLog::record(
            'User Logged In',
            "{$user->name} Logged in"
        );

        if($user->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        if($user->hasRole('receptionist')){
            return redirect()->route('receptionist.dashboard');
        }
        if($user->hasRole('social worker')){
            return redirect()->route('social-worker.dashboard');
        }
        if($user->hasRole('approving officer')){
            return redirect()->route('approving-officer.dashboard');
        }
        if($user->hasRole('cashier')){
            return redirect()->route('cashier.dashboard');
        }

        ActivityLog::record(
            'Login Rejected — No Role',
            "{$user->name} logged in but has no assigned role; logged back out"
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account does not have an assigned role.',
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user(); // fetch current user

        ActivityLog::record(
            'User Logged Out',
            "{$user->name} Logged out"
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
