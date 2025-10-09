<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Student
Route::get('/student', [StudentController::class, 'getAllStudent']);
Route::get('/student/{id}', [StudentController::class, 'showStudent']);
Route::post('/student', [StudentController::class, 'storeStudent']);
Route::post('/login', [StudentController::class, 'login']);
Route::patch('/student/{id}', [StudentController::class, 'updateStudent']);
Route::delete('/student/{id}', [StudentController::class, 'deleteStudent']);

//project


//application history
