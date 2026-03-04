<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::validate($credentials)) {
            $user = \App\Models\User::where('email', $credentials['email'])->first();

            if ($user->status !== 1) {
                return back()->withErrors([
                    'email' => 'Your account is pending administrator approval.',
                ])->onlyInput('email');
            }

            if (Auth::attempt(array_merge($credentials, ['status' => 1]), $remember)) {
                $request->session()->regenerate();

                if (in_array(Auth::user()->role, ['admin', 'agent'])) {
                    return redirect()->intended('admin/dashboard');
                }
                return redirect()->intended('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
