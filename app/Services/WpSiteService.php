<?php

namespace App\Services;

use App\Models\WpSite;
use App\Repositories\WpSiteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;

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
     * @param  Request $request
     * @return mixed
     */
    public function filter(Request $request): mixed
    {
        $response= new stdClass();

        $filter= WpSite::filter($request->input('filters'),$request->input('sort'));

        if(!$request->paginate){
            $response->data= $filter->get();
        }else{
            $response= $filter->paginate($request->paginate);
        }

        return $response;
    }

    public function showUsers(WpSite $wpSite)
    {
         return $this->wpSiteRepository->showUsers( $wpSite);
        
    }
}