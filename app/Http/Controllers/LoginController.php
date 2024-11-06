<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index () {
        return view('login');
    }

    function login (Request $r) {

        $validated = $r->validate([
            'email' => 'required|email:dns|max:100',
            'password' => 'required|string|min:5'
        ]);

        if(Auth::attempt($validated)) {

            $r->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect()->route('login')->with('error', 'Username atau password salah.');
    }

    public function logout(Request $r) {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        
        return redirect('/login');
    }
}
