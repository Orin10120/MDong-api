<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PeriodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Lecturers
Route::apiResource('lecturer', LecturerController::class);
Route::apiResource('interest-topics', TopicController::class);
Route::apiResource('period', PeriodController::class);
