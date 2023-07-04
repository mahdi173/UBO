<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
    require __DIR__.'/users.php';
    require base_path("app/Modules/Poles/routes/poleRoutes.php");
    require base_path("app/Modules/Types/routes/typeRoutes.php");
    require base_path("app/Modules/Roles/routes/roleRoutes.php");
    require base_path("app/Statistiques/Routes/StatistiqueRoutes.php");
    
    Route::get('/logs', [LogController::class, 'index']);
});

Route::post('users/verify-token', [UserController::class, 'verifyToken'])->middleware('verify.email');
Route::post('users/create-password', [UserController::class, 'createPassword'])->middleware('verify.email');

Route::post('users/check-email', [UserController::class, 'checkEmail'])->name('users.checkemail');
Route::post('users/reset-password', [UserController::class, 'resetPassword'])->name('users.resetpassword')->middleware('verify.reset.token');

Route::post('/login', [AuthController::class, 'login']);
