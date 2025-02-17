<?php

namespace App\Services\Interfaces;

interface AuthenticationInterface
{
    // protected function attempt(array $credentials): bool;
    public function check(): bool;
    public function handleLoginRedirect(): mixed;
    public function handleLoginAttempt(array $credentials): mixed;
    public function handleDashboardAccess(): mixed;
    public function handleLogout(): mixed;
}
