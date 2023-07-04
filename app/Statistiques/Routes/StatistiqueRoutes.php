<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatistiqueController;



 Route::get('statistics',[StatistiqueController::class,'statistics']);