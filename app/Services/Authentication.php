<?php

namespace App\Services;

use App\Services\Interfaces\AuthenticationInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Authentication implements AuthenticationInterface
{
    protected function attempt(array $credentials): bool
    {
        return Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);
    }

    public function check(): bool
    {
        return Auth::check();
    }

    public function handleLoginRedirect(): View|RedirectResponse
    {
        if ($this->check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function handleLoginAttempt(array $credentials): RedirectResponse
    {
        if ($this->attempt($credentials)) {
            request()->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()
            ->withInput(['email' => $credentials['email']])
            ->with('error', 'Invalid credentials');
    }

    public function handleDashboardAccess(): View|RedirectResponse
    {
        if (!$this->check()) {
            return redirect('/login')->with('error', 'Please login first');
        }

        // Return dashboard view with user data
        return view('auth.dashboard', [
            'userData' => Auth::user()
        ]);
    }

    public function handleLogout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}
