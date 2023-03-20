<?php

namespace App\Services;

use App\Interfaces\WpSiteRepositoryInterface;
use App\Models\WpSite;
use App\Traits\DeleteObjectTrait;
use Illuminate\Http\JsonResponse;

class WpSiteService
{ 
    use DeleteObjectTrait;
    
     /**
     * __construct
     *
     * @param  WpSiteRepositoryInterface $wpSiteRepository
     * @return void
     */
    public function __construct(private WpSiteRepositoryInterface $wpSiteRepository)
    {
    }

    /**
     * getAllWpSites
     *
     * @return JsonResponse
     */
    public function getAllWpSites(): JsonResponse
    {
        $data =$this->wpSiteRepository->getAllWpSites();
 
        return response()->json($data);
    }
    
    /**
     * storeWpSite
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpSite(array $data): JsonResponse
    {
        $wpSite= $this->wpSiteRepository->createWpSite($data);
    
        return response()->json($wpSite);
    }
    
    /**
     * updateWpSite
     *
     * @param  array $data
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function updateWpSite(array $data, WpSite $wpSite): JsonResponse
    {
        $wpSite->update($data);
        return response()->json($wpSite, 200);
    }
    
    /**
     * deleteWpSite
     *
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function deleteWpSite( WpSite $wpSite): JsonResponse
    {
        return $this->deleteRecord($wpSite);
    }
}