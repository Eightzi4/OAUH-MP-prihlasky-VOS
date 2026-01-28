<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/programy', function () {
    return view('programs.index');
})->name('programs.index');

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/auth/email', [AuthController::class, 'handleEmail'])->name('auth.email');

    Route::post('/auth/password', [AuthController::class, 'loginWithPassword'])->name('auth.password');

    Route::get('/auth/verify', [AuthController::class, 'verifyTicket'])->name('auth.verify');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/application/create', [ApplicationController::class, 'create'])->name('application.create');

    Route::get('/application/{id}/personal', [ApplicationController::class, 'step1'])->name('application.step1');
    Route::post('/application/{id}/personal', [ApplicationController::class, 'storeStep1'])->name('application.storeStep1');

    Route::get('/application/{id}/education', [ApplicationController::class, 'step2'])->name('application.step2');
    Route::post('/application/{id}/education', [ApplicationController::class, 'storeStep2'])->name('application.storeStep2');

    Route::get('/application/{id}/additional', [ApplicationController::class, 'step3'])->name('application.step3');
    Route::post('/application/{id}/additional', [ApplicationController::class, 'storeStep3'])->name('application.storeStep3');
});
