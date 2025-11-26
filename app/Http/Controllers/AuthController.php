<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function handleEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => strstr($email, '@', true)]
        );

        $ticketToken = Str::random(32);

        LoginTicket::create([
            'user_id' => $user->id,
            'token' => $ticketToken,
            'expires_at' => now()->addMinutes(30),
        ]);

        $link = route('auth.verify', ['loginTicket' => $ticketToken]);

        Log::info("LOGIN LINK FOR {$email}: {$link}");

        return view('auth.check-email', ['email' => $email]);
    }

    public function verifyTicket(Request $request) {
        $token = $request->query('loginTicket');

        if (!$token) return redirect()->route('login')->with('error', 'Chybějící přihlašovací token.');

        $ticket = LoginTicket::where('token', $token)
                    ->where('expires_at', '>', now())
                    ->whereNull('used_at')
                    ->first();

        if (!$ticket) return redirect()->route('login')->with('error', 'Neplatný nebo expirovaný odkaz.');

        Auth::login($ticket->user);

        $ticket->update(['used_at' => now()]);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function loginWithPassword(Request $request) {
        return redirect()->route('dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
