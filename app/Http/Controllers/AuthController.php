<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Create user
        $user = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => Hash::make($fields['password']),
            'role'     => 'user', // default role for new users
        ]);

        // Login the user
        Auth::login($user);

        // Redirect
        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'email'    => ['required', 'max:255', 'email'],
            'password' => ['required'],
        ]);

        // Try to login the user
        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();

            // Redirect to normal dashboard
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'failed' => 'Wrong password or email',
        ])->onlyInput('email');
    }

    // Logout the user
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}