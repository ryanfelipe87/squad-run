<?php

use App\Http\Controllers\RegisterUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/register', [RegisterUsersController::class, 'index'])->name('register');
Route::post('/register/create', [RegisterUsersController::class, 'register'])->name('register.create');
Route::get('/users/all', [RegisterUsersController::class, 'getAllUsers'])->name('users.all');
Route::get('/user/{id}', [RegisterUsersController::class, 'getUserById'])->name('user.byId');
