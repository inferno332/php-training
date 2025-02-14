<?php

namespace App\Services;

class Authentication
{
    private $validCredentials = [
        'email' => 'admin@example.com',
        'password' => 'password123'
    ];

    public function attempt(array $credentials): bool
    {
        if ($credentials['email'] === $this->validCredentials['email'] &&
            $credentials['password'] === $this->validCredentials['password']) {
            session(['logged_in' => true]);
            return true;
        }
        return false;
    }

    public function check(): bool
    {
        return session('logged_in', false);
    }

    public function logout(): void
    {
        session()->forget('logged_in');
    }

    public function handleLoginRedirect()
    {
        if ($this->check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function handleLoginAttempt(array $credentials)
    {
        if ($this->attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()
            ->withInput(['email' => $credentials['email']])
            ->with('error', 'Invalid credentials');
    }

    public function handleDashboardAccess()
    {
        if (!$this->check()) {
            return redirect('/login');
        }
        return view('auth.dashboard');
    }

    public function handleLogout()
    {
        $this->logout();
        return redirect('/login');
    }
}
