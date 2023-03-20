<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\WpUser;
use App\Services\WpUserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WpUserController extends Controller
{
     /**
     * __construct
     *
     * @param  WpUserService $wpUserService
     * @return void
     */
    public function __construct(private WpUserService  $wpUserService)
    {
    }
    
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->wpUserService->getAllWpUsers();
    }
    
    /**
     * store
     *
     * @param  RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        return  $this->wpUserService->storeWpUser($request->all());
    }
        
    /**
     * show
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function show(WpUser $wpUser): JsonResponse{
        return response()->json($wpUser);
    }
   
    /**
     * update
     *
     * @param  RegisterRequest $request
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function update(RegisterRequest $request, WpUser $wpUser): JsonResponse
    { 
        return  $this->wpUserService->updateWpUser($request->all(), $wpUser);
    }
    
    /**
     * destroy
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function destroy(WpUser $wpUser): JsonResponse
    {
        return$this->wpUserService->deleteWpUser($wpUser);
    }
}
