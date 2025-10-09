<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lecturer\Api\LecturerController;
use App\Http\Controllers\Lecturer\Api\TopicController;
use App\Http\Controllers\Lecturer\Api\PeriodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Lecturers
Route::apiResource('lecturers', LecturerController::class);
Route::apiResource('topics', TopicController::class);
Route::apiResource('periods', PeriodController::class);
