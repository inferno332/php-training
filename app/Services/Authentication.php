<?php

namespace App\Services;

use App\Services\Interfaces\AuthenticationInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class Authentication implements AuthenticationInterface
{
    private const VALID_CREDENTIALS = [
        'email' => 'admin@example.com',
        'password' => 'password123'
    ];

    protected function attempt(array $credentials): bool
    {
        if ($credentials['email'] === self::VALID_CREDENTIALS['email'] &&
            $credentials['password'] === self::VALID_CREDENTIALS['password']) {
            session(['logged_in' => true]);
            return true;
        }
        return false;
    }

    public function check(): bool
    {
        return session('logged_in', false);
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
            return redirect('/dashboard');
        }

        return back()
            ->withInput(['email' => $credentials['email']])
            ->with('error', 'Invalid credentials');
    }

    public function handleDashboardAccess(): View|RedirectResponse
    {
        if (!$this->check()) {
            return redirect('/login');
        }
        return view('auth.dashboard');
    }

    public function handleLogout(): RedirectResponse
    {
        session()->forget('logged_in');
        return redirect('/login');
    }
}
