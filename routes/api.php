<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\WpRoleController;
use App\Http\Controllers\WpSiteController;
use App\Http\Controllers\WpUserController;
use App\Services\WpPivotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    Route::get('wp-sites', [WpSiteController::class, 'index'])->name('wp-sites.index');
    Route::post('wp-sites', [WpSiteController::class, 'store'])->name('wp-sites.store');
    Route::put('wp-sites/{wpSite}', [WpSiteController::class, 'update'])->name('wp-sites.update');
    Route::delete('wp-sites/{wpSite}', [WpSiteController::class, 'destroy'])->name('wp-sites.destroy');
    Route::get('wp-sites/{wpSite}', [WpSiteController::class, 'show'])->name('wp-sites.show');

    Route::get('wp-users', [WpUserController::class, 'index'])->name('wp-users.index');
    Route::post('wp-users', [WpUserController::class, 'store'])->name('wp-users.store');
    Route::put('wp-users/{wpUser}', [WpUserController::class, 'update'])->name('wp-users.update');
    Route::delete('wp-users/{wpUser}', [WpUserController::class, 'destroy'])->name('wp-users.destroy');
    Route::get('wp-users/{wpUser}', [WpUserController::class, 'show'])->name('wp-users.show');

    Route::get('wp-roles', [WpRoleController::class, 'index'])->name('wp-roles.index');
    Route::post('wp-roles', [WpRoleController::class, 'store'])->name('wp-roles.store');
    Route::put('wp-roles/{wpRole}', [WpRoleController::class, 'update'])->name('wp-roles.update');
    Route::delete('wp-roles/{wpRole}', [WpRoleController::class, 'destroy'])->name('wp-roles.destroy');
    Route::get('wp-roles/{wpRole}', [WpRoleController::class, 'show'])->name('wp-roles.show');

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/email/verify/{id}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);


Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'changePassword'] );