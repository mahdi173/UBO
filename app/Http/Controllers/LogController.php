<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct(private LogService  $logService)
    {
    }

    public function index(Request $request): JsonResponse{
       return response()->json($this->logService->filter($request));
    }
}
