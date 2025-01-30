<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\ChecklistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('servers.index');
});

Route::resource('servers', ServerController::class);
Route::resource('checklists', ChecklistController::class);
Route::post('checklists/{checklist}/approve', [ChecklistController::class, 'approve'])->name('checklists.approve');
