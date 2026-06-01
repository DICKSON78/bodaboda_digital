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

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => 'passenger',
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($request->name),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to BodaBoda! Your account has been created.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $wantJson = $request->expectsJson() || $request->ajax();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->suspended_at) {
                Auth::logout();
                $request->session()->invalidate();
                if ($wantJson) {
                    return response()->json([
                        'message' => 'Your account has been suspended. Contact support for assistance.',
                    ], 403);
                }
                return back()->withErrors([
                    'email' => 'Your account has been suspended. Contact support for assistance.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            $redirect = match ($user->role) {
                'admin' => route('admin.dashboard'),
                default => route('dashboard'),
            };

            if ($wantJson) {
                return response()->json(['redirect' => $redirect]);
            }

            return redirect()->intended($redirect);
        }

        if ($wantJson) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
                'errors' => ['email' => ['The provided credentials do not match our records.']],
            ], 422);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showConfirmForm()
    {
        return view('auth.confirm-password');
    }

    public function confirm(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);

        $request->session()->passwordConfirmed();

        return redirect()->intended();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
