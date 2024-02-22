<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Event/Show', []);
});

Route::resource('clients', ClientController::class)
    ->only(['index', 'store']);

Route::resource('tasks', TaskController::class)
    ->only(['index', 'store']);

Route::post('/tasks/{id}', [TaskController::class, 'send']);

Route::resource('stats', StatsController::class)
    ->only(['index', 'store']);
