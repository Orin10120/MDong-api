<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApplicationHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Student
Route::apiResource('student', StudentController::class);

//project
Route::apiResource('project', ProjectController::class);

//application history
Route::apiResource('applications', ApplicationHistoryController::class);
