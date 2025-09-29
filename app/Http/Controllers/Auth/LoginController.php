<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); //ye jaa kar auth login ko show kary ga 
    }

    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Try login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // new session
            return redirect()->intended('home')->with('success', 'You are logged in!'); // after login ye jaye ga hum page pr 
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email'); // ager error hua tou show kary ga 
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You are logged out!');
    }
}

