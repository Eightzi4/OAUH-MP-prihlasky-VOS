<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'Uchazeč') {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
            return back()->withErrors(['email' => 'Nemáte administrátorská oprávnění.']);
        }

        return back()->withErrors(['email' => 'Nesprávné přihlašovací údaje.']);
    }

    public function dashboard()
    {
        $applications = Application::with(['user', 'studyProgram'])->orderBy('created_at', 'desc')->get();
        $programs = StudyProgram::all();

        return view('admin.dashboard', compact('applications', 'programs'));
    }

    public function showApplication($id)
    {
        $application = Application::with(['user', 'studyProgram', 'attachments'])->findOrFail($id);

        return view('admin.application_show', compact('application'));
    }
}
