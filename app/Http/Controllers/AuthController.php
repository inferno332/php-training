<?php

namespace App\Http\Controllers;

use App\Services\Authentication;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function showLogin()
    {
        return $this->auth->handleLoginRedirect();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        return $this->auth->handleLoginAttempt($request->only(['email', 'password']));
    }

    public function dashboard()
    {
        return $this->auth->handleDashboardAccess();
    }

    public function logout()
    {
        return $this->auth->handleLogout();
    }
}
