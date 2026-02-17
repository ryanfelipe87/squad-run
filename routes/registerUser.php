<?php

use App\Http\Controllers\RegisterUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterUsersController::class, 'index'])->name('register');
Route::post('/register/create', [RegisterUsersController::class, 'register'])->name('register.create');
