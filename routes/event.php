<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/events/all', [EventController::class, 'getAllEvents'])->name('events.all');
Route::get('/event/{id}', [EventController::class, 'getEventById'])->name('event.byId');
Route::post('/event/create', [EventController::class, 'createEvent'])->name('event.create');
Route::put('/event/update-event-by-id/{id}', [EventController::class, 'updateEvent'])->name('event.updateEvent');
Route::delete('/event/delete-event-by-id/{id}', [EventController::class, 'deleteEvent'])->name('event.deleteEvent');
