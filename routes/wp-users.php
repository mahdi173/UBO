<?php

use App\Http\Controllers\WpUserController;
use Illuminate\Support\Facades\Route;

Route::get('wp-users', [WpUserController::class, 'index'])->name('wp-users.index');
Route::post('wp-users', [WpUserController::class, 'store'])->name('wp-users.store');
Route::put('wp-users/{wpUser}', [WpUserController::class, 'update'])->name('wp-users.update');
Route::delete('wp-users/{wpUser}', [WpUserController::class, 'destroy'])->name('wp-users.destroy');
Route::get('wp-users/{wpUser}', [WpUserController::class, 'show'])->name('wp-users.show');