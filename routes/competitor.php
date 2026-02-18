<?php

use App\Http\Controllers\CompetitorController;
use Illuminate\Support\Facades\Route;

Route::get('/competitors/all', [CompetitorController::class, 'allCompetitors'])->name('competitors.all');
Route::get('/competitor/{id}', [CompetitorController::class, 'getCompetitorById'])->name('competitor.byId');
Route::post('/competitor/create', [CompetitorController::class, 'createCompetitor'])->name('competitor.create');
