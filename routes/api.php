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

// Application History - Lecturer relationship
Route::get('applications/{id}/lecturers', [ApplicationHistoryController::class, 'lecturers']);
Route::post('applications/{id}/attach-lecturer', [ApplicationHistoryController::class, 'attachLecturer']);
Route::post('applications/{id}/detach-lecturer', [ApplicationHistoryController::class, 'detachLecturer']);

// Lecturer - Application History relationship (OPSIONAL)
Route::get('lecturers/{id}/histories', [LecturerController::class, 'histories']);
Route::post('lecturers/{id}/attach-history', [LecturerController::class, 'attachHistory']);
Route::post('lecturers/{id}/detach-history', [LecturerController::class, 'detachHistory']);
