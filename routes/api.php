<?php

use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrganizationController;
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
Route::middleware('auth:sanctum')->group(function(){
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users/all', [RegisterUsersController::class, 'getAllUsers'])->name('users.all');
    Route::get('/user/{id}', [RegisterUsersController::class, 'getUserById'])->name('user.byId');
    Route::put('/user/update-user-by-id/{id}', [RegisterUsersController::class, 'updateUserById'])->name('user.updateUserById');
    Route::delete('/user/delete-user-by-id/{id}', [RegisterUsersController::class, 'deleteUserById'])->name('user.deleteUserById');

    Route::get('/organizations/all', [OrganizationController::class, 'allOrganizations'])->name('organizations.all');
    Route::post('/organization/create', [OrganizationController::class, 'createOrganization'])->name('organization.create');
    Route::get('/organization/{id}', [OrganizationController::class, 'getOrganizationById'])->name('organization.byId');
    Route::put('/organization/update-organization-by-id/{id}', [OrganizationController::class, 'updateOrganization'])->name('organization.updateOrganization');
    Route::delete('/organization/delete-organization-by-id/{id}', [OrganizationController::class, 'deleteOrganization'])->name('organization.deleteOrganization');

    Route::get('/competitors/all', [CompetitorController::class, 'allCompetitors'])->name('competitors.all');
    Route::get('/competitor/{id}', [CompetitorController::class, 'getCompetitorById'])->name('competitor.byId');
    Route::post('/competitor/create', [CompetitorController::class, 'createCompetitor'])->name('competitor.create');

    Route::get('/events/all', [EventController::class, 'getAllEvents'])->name('events.all');
    Route::get('/event/{id}', [EventController::class, 'getEventById'])->name('event.byId');
    Route::post('/event/create', [EventController::class, 'createEvent'])->name('event.create');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('login/authenticate', [LoginController::class, 'login'])->name('login.authenticate');
Route::get('/register', [RegisterUsersController::class, 'index'])->name('register');
Route::post('/register/create', [RegisterUsersController::class, 'register'])->name('register.create');
