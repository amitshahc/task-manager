<?php

use Illuminate\Support\Facades\Route;
use Modules\Tasks\Http\Controllers\ProjectsController;
use Modules\Tasks\Http\Controllers\TasksController;
use Modules\Tasks\Http\Middleware\Sanitizer;

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

Route::group([], function () {
    Route::resource('tasks', TasksController::class)->names('tasks');
    Route::resource('projects', ProjectsController::class)->names('projects');
    Route::post('tasks/reorder', [TasksController::class, 'reorder'])->name('tasks.reorder');
})->middleware([Sanitizer::class]) ;
