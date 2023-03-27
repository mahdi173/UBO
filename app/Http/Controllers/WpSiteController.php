<?php

namespace App\Http\Controllers;

use App\Filters\WpSiteFilters;
use App\Http\Requests\StoreWpSiteRequest;
use App\Models\WpSite;
use App\Services\WpSiteService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function index(WpSiteFilters $filters): JsonResponse
    {
       return $this->wpSiteService->filter($filters);
    }
     
    /**
     * store
     *
     * @param  StoreWpSiteRequest $request
     * @return JsonResponse
     */
    public function store(StoreWpSiteRequest $request): JsonResponse
    {
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
    public function update(StoreWpSiteRequest $request, WpSite $wpSite): JsonResponse
    {
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
        return $this->wpSiteService->deleteWpSite($wpSite);
    }
}
