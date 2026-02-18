<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/organization/{id}', [OrganizationController::class, 'index'])->name('organization.byId');
Route::get('/oganizations/all', [OrganizationController::class, 'allOrganizations'])->name('organizations.all');
Route::post('/organization/create', [OrganizationController::class, 'create'])->name('organization.create');
