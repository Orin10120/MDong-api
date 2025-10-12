<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApplicationHistoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PeriodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::apiResource('students', StudentController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('applications', ApplicationHistoryController::class);
Route::apiResource('lecturers', LecturerController::class);
Route::apiResource('topics', TopicController::class);
Route::apiResource('periods', PeriodController::class);

