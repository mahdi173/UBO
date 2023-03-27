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
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        $queryFilters= $request->only($this->filters);
        
        if($request->sort && $request->order){ 
            $sortValues= explode(',', $request->sort);
            $orderValues= explode(',', $request->order);
            
            foreach($sortValues as $key=>$item){
                if(!in_array($item, $this->filters)){
                    $sortValues=null;
                }
            }       

            if($sortValues){
                foreach($orderValues as $key=>$item){
                    if($item!="asc" && $item!="desc"){
                        $orderValues[$key]="asc";
                    }
                }

                $results= WpSite::filter($queryFilters, $request->paginate, $sortValues, $orderValues);
            }            
        }else{
            $results= WpSite::filter($queryFilters, $request->paginate);
        }


        if($results instanceof Builder){
            if(!empty($results->get()->toArray()) ){
                return  response()->json(["data"=> $results->get()]);
            }
        }else if(!empty($results->toArray()["data"])){
            return response()->json($results);
        }

        return response()->json(["msg"=> "No Results"], 404);
    }
}