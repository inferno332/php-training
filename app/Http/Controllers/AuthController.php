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
        if ($this->auth->check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if ($this->auth->attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid credentials');
    }

    public function dashboard()
    {
        if (!$this->auth->check()) {
            return redirect('/login');
        }
        return view('auth.dashboard');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect('/login');
    }
}
