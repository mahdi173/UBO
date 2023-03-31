<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;

Route::get('types',[TypeController::class,'index']);
Route::prefix('/type')-> group (function () {
    Route::post('/add',[TypeController::class ,'store']);
    Route::put('/update/{id}', [TypeController::class ,'update']);
    Route::delete('/delete/{id}', [TypeController::class ,'destroy']);
});
