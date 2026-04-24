<?php

use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\EnrollEventCompetitorController;
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

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/users/all', [RegisterUsersController::class, 'index'])->name('users.all');
    Route::get('/user/{id}', [RegisterUsersController::class, 'show'])->name('user.byId');
    Route::put('/user/update-user-by-id/{id}', [RegisterUsersController::class, 'update'])->name('user.updateUserById');
    Route::delete('/user/delete-user-by-id/{id}', [RegisterUsersController::class, 'delete'])->name('user.deleteUserById');

    Route::get('/organizations/all', [OrganizationController::class, 'allOrganizations'])->name('organizations.all');
    Route::post('/organization/create', [OrganizationController::class, 'createOrganization'])->name('organization.create');
    Route::get('/organization/{id}', [OrganizationController::class, 'getOrganizationById'])->name('organization.byId');
    Route::put('/organization/update-organization-by-id/{id}', [OrganizationController::class, 'updateOrganization'])->name('organization.updateOrganization');
    Route::delete('/organization/delete-organization-by-id/{id}', [OrganizationController::class, 'deleteOrganization'])->name('organization.deleteOrganization');

    Route::get('/competitors/all', [CompetitorController::class, 'index'])->name('competitors.all');
    Route::get('/competitor/my-events', [CompetitorController::class, 'myEvents'])->name('competitor.events');
    Route::get('/competitor/{id}', [CompetitorController::class, 'show'])->name('competitor.byId');
    Route::post('/competitor/create', [CompetitorController::class, 'store'])->name('competitor.create');
    Route::put('/competitor/update/{id}', [CompetitorController::class, 'update'])->name('competitor.update');
    Route::delete('/competitor/delete/{id}', [CompetitorController::class, 'destroy'])->name('competitor.delete');

    Route::post('/event/{event}/subscribe', [EnrollEventCompetitorController::class, 'subscribeEvent'])->name('enroll.subscribe');

    Route::get('/events/all', [EventController::class, 'index'])->name('events.all');
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.byId');
    Route::post('/event/create', [EventController::class, 'store'])->name('event.create');
    Route::put('/event/update-event-by-id/{id}', [EventController::class, 'update'])->name('event.updateEvent');
    Route::delete('/event/delete-event-by-id/{id}', [EventController::class, 'destroy'])->name('event.deleteEvent');
    Route::get('/event/{id}/ranking', [EventController::class, 'ranking'])->name('event.ranking');
    Route::post('/event/{id}/finish', [EventController::class, 'finish'])->name('event.finishEvent');
    Route::post('/organization/{id}/finish-events', [EventController::class, 'finishAll'])->name('event.finishEventsByOrganization');
    Route::post('/event/{id}/register-result', [EventController::class, 'registerResult'])->name('event.registerResult');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('login/authenticate', [LoginController::class, 'login'])->name('login.authenticate');
Route::post('/refresh', [LoginController::class, 'refresh']);
Route::get('/register', [RegisterUsersController::class, 'index'])->name('register');
Route::post('/register/create', [RegisterUsersController::class, 'register'])->name('register.create');
