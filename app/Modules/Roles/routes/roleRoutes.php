<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::get('roles',[RoleController::class,'index']);
Route::prefix('/roles')-> group (function () {
    Route::get('/trash',[RoleController::class,'showDeletedData']);
    Route::post('/',[RoleController::class ,'store']);
    Route::put('/{id}', [RoleController::class ,'update']);
    Route::delete('{id}', [RoleController::class ,'destroy']);
    Route::get('/{id}', [RoleController::class ,'show']); 
    Route::patch('/{id}', [RoleController::class ,'restore']);
});
