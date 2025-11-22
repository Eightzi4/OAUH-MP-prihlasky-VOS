<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function handleEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');

        return view('auth.check-email', ['email' => $email]);
    }

    public function loginWithPassword(Request $request) {
        return redirect()->route('dashboard');
    }

    public function verifyTicket() {
        return redirect()->route('dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
