<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TaskController;
use \App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TaskController::class, 'create'])->name('task.create');
Route::post('/tasks',  [TaskController::class, 'store'])->name('task.store');
Route::get('/tasks',  [TaskController::class, 'index'])->name('task.list');
Route::get('/statistics',  [StatisticsController::class, 'index'])->name('statistics.list');
