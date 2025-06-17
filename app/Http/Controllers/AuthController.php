<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    private const REDIRECT_ROUTE = 'backoffice.orders.index';

    public function login()
    {
        if (auth()->check()) {
            return redirect()->route(self::REDIRECT_ROUTE);
        }

        return inertia('BackOffice/Login', [
            'csrf' => csrf_token()
        ]);
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route(self::REDIRECT_ROUTE);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
