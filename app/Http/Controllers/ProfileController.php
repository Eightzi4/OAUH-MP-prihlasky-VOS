<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
        ]);

        $user = User::findOrFail(Auth::id());
        $user->email = $request->email;
        $user->save();

        if ($user->application && $user->application->details) {
            $user->application->details->update(['email' => $request->email]);
        }

        return redirect()->back()->with('success', 'Email byl úspěšně změněn.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::findOrFail(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Heslo bylo úspěšně nastaveno.');
    }
}
