<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;

Route::get('types',[TypeController::class,'index']);
Route::prefix('/types')-> group (function () {
    Route::post('/',[TypeController::class ,'store']);
    Route::put('/{id}', [TypeController::class ,'update']);
    Route::delete('/{id}', [TypeController::class ,'destroy']);
    Route::get('/{id}', [TypeController::class ,'show']);
});
