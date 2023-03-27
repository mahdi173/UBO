<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    require __DIR__.'/wp-roles.php';
    require __DIR__.'/wp-sites.php';
    require __DIR__.'/wp-users.php';
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Routes des Poles 
//require __DIR__. "/App/Modules/Poles/routes/poleRoutes.php";


Route::resource('poles', PoleController::class);
Route::get('poles',[PoleController::class,'index']);
Route::get('polesBy',[PoleController::class,'searchBy']);
Route::prefix('/pole')-> group (function () {
    Route::post('/add',[PoleController::class ,'store']);
    Route::put('/update/{id}', [PoleController::class ,'update']);
    Route::delete('/delete/{id}', [PoleController::class ,'destroy']);
});


// Routes des Types
//Route::resource('types', TypeController::class);
Route::get('typeBy',[TypeController::class,'searchBy']);
Route::get('types',[TypeController::class,'index']);
Route::prefix('/type')-> group (function () {
    Route::post('/add',[TypeController::class ,'store']);
    Route::put('/update/{id}', [TypeController::class ,'update']);
    Route::delete('/delete/{id}', [TypeController::class ,'destroy']);
});

// Routes des Roles
//Route::resource('roles', RoleController::class);
Route::get('roleBy',[RoleController::class,'searchBy']);
Route::get('roles',[RoleController::class,'index']);
Route::prefix('/role')-> group (function () {
    Route::post('/add',[RoleController::class ,'store']);
    Route::put('/update/{id}', [RoleController::class ,'update']);
    Route::delete('/delete/{id}', [RoleController::class ,'destroy']);
});
