<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardAdmin;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'Login']);

Route::get('/users', [UserController::class, 'index']);


Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{event}', [EventController::class, 'show']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy']);

Route::get('/courses', [CourseController::class, 'index']);
Route::post('/courses', [CourseController::class, 'store']);
Route::get('/courses/{courses}', [CourseController::class, 'show']);
Route::put('/courses/{courses}', [CourseController::class, 'update']);
Route::delete('/courses/{courses}', [CourseController::class, 'destroy']);


Route::get('admin/dashboard', [DashboardAdmin::class, 'status']);

Route::middleware('auth:sanctum')->get('/userprofile', function (Request $request) {
    return response()->json($request->user());
});