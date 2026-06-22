<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RegisterUsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function(){
    Route::get('/register', [RegisterUsersController::class, 'create'])->name('register');
    Route::post('/register', [RegisterUsersController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {

    // Tela "verifique seu email"
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Link enviado no email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/users');
    })->middleware(['signed'])->name('verification.verify');

    // Reenvio do email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'E-mail de verificação reenviado!');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    Route::get('/', [RegisterUsersController::class, 'index'])->name('index');
    Route::get('/{id}', [RegisterUsersController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [RegisterUsersController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RegisterUsersController::class, 'update'])->name('update');
    Route::delete('/{id}', [RegisterUsersController::class, 'destroy'])->name('destroy');
});