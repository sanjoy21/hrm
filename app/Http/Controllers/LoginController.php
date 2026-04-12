<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('management')->check()) {
            return redirect()->route('management.dashboard');
        }

        if (Auth::check()) {
            return redirect()->route('employee_dashboard');
        }

        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // 1) Admin login
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::guard('admin')->user();

            if (strtolower($user->role) !== 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('login')->with('error', 'Unauthorized access.');
            }

            if ($user->status !== 'active') {
                Auth::guard('admin')->logout();
                return back()->with('error', 'Your account is inactive.');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        // 2) Management login
        elseif (Auth::guard('management')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::guard('management')->user();

            if (strtolower($user->role) !== 'management') {
                Auth::guard('management')->logout();
                return redirect()->route('login')->with('error', 'Unauthorized access.');
            }

            if ($user->status !== 'active') {
                Auth::guard('management')->logout();
                return back()->with('error', 'Your account is inactive.');
            }

            return redirect()->intended(route('management.dashboard'));
        }

        // 3) Employee login (default web guard)
        elseif (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (strtolower($user->role) !== 'employee') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Unauthorized access.');
            }

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->with('error', 'Your account is inactive.');
            }

            return redirect()->intended(route('employee_dashboard'));
        }

        // 4) Invalid credentials
        return back()->withInput($request->only('email'))
            ->with('error', 'Invalid credentials.');
    }
}
