<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::get('roles',[RoleController::class,'index']);
Route::prefix('/role')-> group (function () {
    Route::post('/add',[RoleController::class ,'store']);
    Route::put('/update/{id}', [RoleController::class ,'update']);
    Route::delete('/delete/{id}', [RoleController::class ,'destroy']);
});
