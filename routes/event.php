<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('events')->name('events.')->group(function(){
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/create', [EventController::class, 'create'])->name('create');
    Route::post('/', [EventController::class, 'store'])->name('store');
    Route::get('/{id}', [EventController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EventController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/ranking', [EventController::class, 'ranking'])->name('ranking');
    Route::post('/{id}/finish', [EventController::class, 'finish'])->name('finish');
    Route::post('/finish-all', [EventController::class, 'finishAll'])->name('finish-all');
    Route::post('/{id}/register-result', [EventController::class, 'registerResult'])->name('register-result');
});