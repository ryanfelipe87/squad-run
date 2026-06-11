<?php

use App\Http\Controllers\EnrollEventCompetitorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/event/{event}/subscribe', [EnrollEventCompetitorController::class, 'subscribeEvent'])->name('enroll.subscribe');
});