<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskWebController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', function () {
    return redirect('/tasks');
});

Route::get('/tasks', [TaskWebController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskWebController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskWebController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskWebController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskWebController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskWebController::class, 'destroy'])->name('tasks.destroy');
