<?php

namespace App\Services;

use App\Filters\WpUserFilters;
use App\Models\WpUser;
use App\Repositories\WpUserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WpUserService
{       
    protected $filters = [
        'id',
        'userName' ,
        'firstName',
        'lastName',
        'email',
        'created_at',
        'updated_at'
    ];

    /**
     * __construct
     *
     * @param  WpUserRepository $wpUserRepository
     * @return void
     */
    public function __construct(private WpUserRepository $wpUserRepository)
    {
    }
    
    /**
     * storeWpUser
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpUser(array $data): JsonResponse 
    { 
        $wpUser = $this->wpUserRepository->create($data);
        return response()->json($wpUser, 200);
    }
    
    /**
     * updateWpUser
     *
     * @param  array $data
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function updateWpUser(array $data, WpUser $wpUser): JsonResponse
    {
        $this->wpUserRepository->update($wpUser, $data);
        return response()->json($wpUser, 200);
    }
    
    /**
     * deleteWpUser
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function deleteWpUser( WpUser $wpUser): JsonResponse
    {
        $this->wpUserRepository->delete($wpUser);
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

                $results= WpUser::filter($queryFilters, $request->paginate, $sortValues, $orderValues);
            }            
        }else{
            $results= WpUser::filter($queryFilters, $request->paginate);
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