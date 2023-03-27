<?php

namespace App\Services;

use App\Filters\WpSiteFilters;
use App\Models\WpSite;
use App\Repositories\WpSiteRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class WpSiteService
{     
     /**
     * __construct
     *
     * @param  WpSiteRepository $wpSiteRepository
     * @return void
     */
    public function __construct(private WpSiteRepository $wpSiteRepository)
    {
    }
    
    /**
     * storeWpSite
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpSite(array $data): JsonResponse
    {
        $wpSite= $this->wpSiteRepository->create($data);
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
        $this->wpSiteRepository->update($wpSite, $data);
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
        $this->wpSiteRepository->delete($wpSite);
        return response()->json(["msg"=>"Item successfully deleted!"], 200);
    }
    
    /**
     * filter
     *
     * @param  WpSiteFilters $filters
     * @return JsonResponse
     */
    public function filter(WpSiteFilters $filters): JsonResponse
    {
        $results= WpSite::filter($filters);

        if(!$results){
            return response()->json(["msg"=>"Invalid query params!"], 422);
        }

        if($results instanceof Builder){
            if(!empty($results->get()->toArray()) ){
                return  response()->json(["data"=> $results->get()]);
            }
        }else if(!empty($results->toArray()["data"])){
            return response()->json($results);
        }
        
        return response()->json(["msg"=>"No results!"]);
    }
}