<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/organization/{id}', [OrganizationController::class, 'getOrganizationById'])->name('organization.byId');
Route::get('/organizations/all', [OrganizationController::class, 'allOrganizations'])->name('organizations.all');
Route::post('/organization/create', [OrganizationController::class, 'createOrganization'])->name('organization.create');
