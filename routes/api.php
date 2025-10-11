<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApplicationHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Student
Route::apiResource('students', StudentController::class);

//project
Route::apiResource('projects', ProjectController::class);

//application history
Route::apiResource('applications', ApplicationHistoryController::class);
