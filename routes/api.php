<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectAttributeController;

//CRUD calls that dont require auth token (the token will be created after the login ofcourse)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    //base CRUD calls for each models api
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('timesheets', TimesheetController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('attribute-values', AttributeValueController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    //specific CRUD calls for each models api, I know its messy :P
    Route::post('/projects/{id}/attributes', [ProjectAttributeController::class, 'setAttributes']);
    Route::get('/projects/{id}/attributes', [ProjectAttributeController::class, 'getAttributes']);
    Route::post('projects/{projectId}/assign-users', [ProjectController::class, 'assignUsers']);
    // Route::get('/projects', [ProjectController::class, 'filter']);
    Route::post('/users/{id}', [UserController::class, 'update']);
});