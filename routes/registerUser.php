<?php

use App\Http\Controllers\RegisterUsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    Route::get('/register', [RegisterUsersController::class, 'create'])->name('register');
    Route::post('/register', [RegisterUsersController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    Route::get('/', [RegisterUsersController::class, 'index'])->name('index');
    Route::get('/{id}', [RegisterUsersController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [RegisterUsersController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RegisterUsersController::class, 'update'])->name('update');
    Route::delete('/{id}', [RegisterUsersController::class, 'destroy'])->name('destroy');
});