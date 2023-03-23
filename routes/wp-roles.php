<?php

use App\Http\Controllers\WpRoleController;
use Illuminate\Support\Facades\Route;

Route::get('wp-roles', [WpRoleController::class, 'index'])->name('wp-roles.index');
Route::post('wp-roles', [WpRoleController::class, 'store'])->name('wp-roles.store');
Route::put('wp-roles/{wpRole}', [WpRoleController::class, 'update'])->name('wp-roles.update');
Route::delete('wp-roles/{wpRole}', [WpRoleController::class, 'destroy'])->name('wp-roles.destroy');
Route::get('wp-roles/{wpRole}', [WpRoleController::class, 'show'])->name('wp-roles.show');
