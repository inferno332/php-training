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
}
