<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NiaController;
use App\Http\Controllers\NiaMockController;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/programs', [ApplicationController::class, 'programsIndex'])->name('programs.index');

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/auth/email', [AuthController::class, 'handleEmail'])->name('auth.email');

    Route::post('/auth/password', [AuthController::class, 'loginWithPassword'])->name('auth.password');

    Route::post('/auth/send-link', [AuthController::class, 'sendLink'])->name('auth.send-link');

    Route::get('/auth/verify', [AuthController::class, 'verifyTicket'])->name('auth.verify');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $applications = Application::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('applications'));
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/nia/real-login/{applicationId}', [NiaController::class, 'login'])->name('nia.real.login');
    Route::get('/nia/mock-login/{applicationId}', [NiaMockController::class, 'login'])->name('nia.mock.login');
    Route::get('/nia/callback', [NiaMockController::class, 'callback'])->name('nia.mock.callback');

    Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/application/create/{program_id}', [ApplicationController::class, 'create'])->name('application.create');

    Route::get('/application/{id}/personal', [ApplicationController::class, 'step1'])->name('application.step1');
    Route::post('/application/{id}/personal', [ApplicationController::class, 'storeStep1'])->name('application.storeStep1');

    Route::get('/application/{id}/education', [ApplicationController::class, 'step2'])->name('application.step2');
    Route::post('/application/{id}/education', [ApplicationController::class, 'storeStep2'])->name('application.storeStep2');

    Route::get('/application/{id}/additional', [ApplicationController::class, 'step3'])->name('application.step3');
    Route::post('/application/{id}/additional', [ApplicationController::class, 'storeStep3'])->name('application.storeStep3');

    Route::get('/application/{id}/summary', [ApplicationController::class, 'step4'])->name('application.step4');
    Route::post('/application/{id}/submit', [ApplicationController::class, 'submit'])->name('application.submit');

    Route::delete('/application/{id}/attachment/{attachmentId}', [ApplicationController::class, 'deleteAttachment'])->name('application.deleteAttachment');
});
