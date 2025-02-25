<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;

// Route::apiResource('attributes', AttributeController::class);
// Route::apiResource('projects/{projectId}/attribute-values', AttributeValueController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/projects', ProjectController::class);
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::apiResource('/timesheets', TimesheetController::class);
    Route::apiResource('/attributes', AttributeController::class);
    Route::apiResource('/attribute-values', AttributeValueController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});