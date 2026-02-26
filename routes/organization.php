<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/organization/{id}', [OrganizationController::class, 'getOrganizationById'])->name('organization.byId');
Route::get('/organizations/all', [OrganizationController::class, 'allOrganizations'])->name('organizations.all');
Route::post('/organization/create', [OrganizationController::class, 'createOrganization'])->name('organization.create');
Route::put('/organization/update-organization-by-id/{id}', [OrganizationController::class, 'updateOrganization'])->name('organization.updateOrganization');
Route::delete('/organization/delete-organization-by-id/{id}', [OrganizationController::class, 'deleteOrganization'])->name('organization.deleteOrganization');
