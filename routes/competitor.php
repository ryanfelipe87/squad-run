<?php

use App\Http\Controllers\CompetitorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('competitors')->name('competitors.')->group(function(){
    Route::get('/', [CompetitorController::class, 'index'])->name('index');
    Route::get('/create', [CompetitorController::class, 'create'])->name('create');
    Route::post('/', [CompetitorController::class, 'store'])->name('store');
    Route::get('/my-events', [CompetitorController::class, 'myEvents'])->name('events');
    Route::get('/{id}', [CompetitorController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [CompetitorController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CompetitorController::class, 'update'])->name('update');
    Route::delete('/{id}', [CompetitorController::class, 'destroy'])->name('destroy');
});
