<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\AuthController;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

use App\Http\Controllers\Api\StudentController;

// Student Routes (Sanctum Auth)
Route::middleware(['auth:sanctum'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard']);
    Route::get('/courses', [StudentController::class, 'myCourses']);
    Route::get('/courses/{id}', [StudentController::class, 'courseDetail']);
    Route::get('/schedule', [StudentController::class, 'schedule']);
});

// Instructor Routes (Sanctum Auth)
Route::middleware(['auth:sanctum'])->prefix('instructor')->group(function () {
    // Add instructor specific routes here
});

