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
Route::apiResource('dosen', LecturerController::class);
Route::apiResource('topik-interest', TopicController::class);
Route::apiResource('periode', PeriodController::class);
