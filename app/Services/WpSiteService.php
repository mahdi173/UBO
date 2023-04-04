<?php

namespace App\Services;

use App\Filters\WpSiteFilters;
use App\Models\WpSite;
use App\Repositories\WpSiteRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WpSiteService
{   
    protected $filters = [
        'id',
        'name',
        'domain',
        'pole',
        'type',
        'created_at',
        'updated_at',
    ];

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
        return response()->json($wpSite->load('pole', 'type'));
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
        return response()->json($wpSite->load('pole', 'type'), 200);
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
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        $results= WpSite::filter($request->input('filters'),$request->input('sort') ,$request->paginate);

        if(!$request->paginate){
            return  response()->json(["data"=> $results->get()]);
        }else{
            return response()->json($results);
        }
    }
    public function showUsers(WpSite $wpSite)
    {
         return $this->wpSiteRepository->showUsers( $wpSite);
        
    }
}