<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardAdmin;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/exportar-dados', function () {
    return Excel::download(new UsuariosExport, 'dados.xlsx');
});



Route::post("/apply_opportunities/{id}", [ApplicationController::class, "applyCourse"])->middleware('auth:sanctum');
Route::get("/apply_opportunities", [ApplicationController::class, "index"]);

Route::post('/register', [AuthController::class, 'newUser']);
Route::post('/login', [AuthController::class, 'Login'])->middleware('throttle:5,1');
Route::get('/confirm-email/{token}', [AuthController::class, 'confirmEmail']);


Route::get('/users', [UserController::class, 'index']);


Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store'])->middleware("auth:sanctum");
Route::get('/events/{event}', [EventController::class, 'show']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy']);

Route::get('/courses', [CourseController::class, 'index']);
Route::post('/courses', [CourseController::class, 'store'])->middleware("auth:sanctum");
Route::get('/courses/{courses}', [CourseController::class, 'show']);
Route::put('/courses/{courses}', [CourseController::class, 'update']);
Route::delete('/courses/{course}', [CourseController::class, 'destroy']);


Route::get('admin/dashboard', [DashboardAdmin::class, 'status']);

Route::middleware('auth:sanctum')->get('/userprofile', function (Request $request) {
    return response()->json($request->user());
});
Route::options('/{any}', function() {
    return response()->json([], 204)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');