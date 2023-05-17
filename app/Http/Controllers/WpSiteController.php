<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWpSiteRequest;
use App\Http\Requests\UpdateWpSiteRequest;
use App\Models\WpSite;
use App\Services\WpSiteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WpSiteController extends Controller
{
      /**
     * __construct
     *
     * @param  WpSiteService $wpSiteService
     * @return void
     */
    public function __construct(private WpSiteService  $wpSiteService)
    {
    }

    /**
     * index
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
       return $this->wpSiteService->filter($request);
    }
     
    /**
     * store
     *
     * @param  StoreWpSiteRequest $request
     * @return JsonResponse
     */
    public function store(StoreWpSiteRequest $request): JsonResponse
    {
        $this->authorize('view');

        return $this->wpSiteService->storeWpSite($request->all());
    }
    
    /**
     * show
     *
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function show(WpSite $wpSite): JsonResponse{
        return response()->json($wpSite);
    }
   
    /**
     * update
     *
     * @param  StoreWpSiteRequest $request
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function update(UpdateWpSiteRequest $request, WpSite $wpSite): JsonResponse
    {
        $this->authorize('view');

        return  $this->wpSiteService->updateWpSite($request->all(), $wpSite);
    }

    
    /**
     * destroy
     *
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function destroy( WpSite $wpSite): JsonResponse
    {
        $this->authorize('view');

        return $this->wpSiteService->deleteWpSite($wpSite);
    }

    public function showUsers( WpSite $wpSite)
    {
         return $this->wpSiteService->showUsers($wpSite);
    }
}

