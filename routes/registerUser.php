<?php

use App\Http\Controllers\RegisterUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterUsersController::class, 'index'])->name('register');
Route::post('/register/create', [RegisterUsersController::class, 'register'])->name('register.create');
Route::get('/register/get-all-users', [RegisterUsersController::class, 'getAllUsers'])->name('register.getAllUsers');
Route::get('/register/get-user-by-id/{id}', [RegisterUsersController::class, 'getUserById'])->name('register.getUserById');
Route::put('/register/update-user-by-id/{id}', [RegisterUsersController::class, 'updateUserById'])->name('register.updateUserById');
Route::delete('/register/delete-user-by-id/{id}', [RegisterUsersController::class, 'deleteUserById'])->name('register.deleteUserById');
