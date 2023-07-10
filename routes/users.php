<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::get('users/trash', [UserController::class, 'showDeletedData']);
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
Route::patch('users/{id}', [UserController::class ,'restore']);