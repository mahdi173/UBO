<?php

use App\Http\Controllers\WpSiteController;
use Illuminate\Support\Facades\Route;

Route::get('wp-sites', [WpSiteController::class, 'index'])->name('wp-sites.index');
Route::post('wp-sites', [WpSiteController::class, 'store'])->name('wp-sites.store');
Route::put('wp-sites/{wpSite}', [WpSiteController::class, 'update'])->name('wp-sites.update');
Route::delete('wp-sites/{wpSite}', [WpSiteController::class, 'destroy'])->name('wp-sites.destroy');
Route::get('wp-sites/{wpSite}', [WpSiteController::class, 'show'])->name('wp-sites.show');