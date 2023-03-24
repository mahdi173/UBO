<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoleController;



Route::get('poles',[PoleController::class,'index']);
Route::get('polesBy',[PoleController::class,'SearchByName']);
Route::prefix('/pole')-> group (function () {
    Route::post('/add',[PoleController::class ,'store']);
    Route::put('/update/{id}', [PoleController::class ,'update']);
    Route::delete('/delete/{id}', [PoleController::class ,'destroy']);
});
