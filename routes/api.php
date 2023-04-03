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
  require __DIR__. "/../app/Modules/Poles/routes/poleRoutes.php"; 

// Routes des Types
require __DIR__. "/../app/Modules/Types/routes/typeRoutes.php"; 

//Routes Roles
require __DIR__. "/../app/Modules/Roles/routes/roleRoutes.php"; 
