<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('organizations')->name('organizations.')->group(function(){
    Route::get('/', [OrganizationController::class, 'index'])->name('index');
    Route::get('/create', [OrganizationController::class, 'create'])->name('create');
    Route::post('/', [OrganizationController::class, 'store'])->name('store');
    Route::get('/{id}', [OrganizationController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [OrganizationController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OrganizationController::class, 'update'])->name('update');
    Route::delete('/{id}', [OrganizationController::class, 'destroy'])->name('destroy');
});