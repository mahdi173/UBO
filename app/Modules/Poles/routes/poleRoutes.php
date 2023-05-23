<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoleController;




Route::get('poles',[PoleController::class,'index']);

Route::prefix('/poles')-> group (function () {
    Route::get('/trash',[PoleController::class,'showDeletedData']);
    Route::post('/',[PoleController::class ,'store']);
    Route::put('/{id}', [PoleController::class ,'update']);
    Route::delete('/{id}', [PoleController::class ,'destroy']);
    Route::get('/{id}', [PoleController::class ,'show']);
    Route::patch('/{id}', [PoleController::class ,'restore']);   
});

