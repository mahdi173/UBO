<?php

namespace App\Services;

use App\Filters\WpRoleFilters;
use App\Models\WpRole;
use App\Repositories\WpRoleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WpRoleService
{     
    protected $filters = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * __construct
     *
     * @param  WpRoleRepository $roleRepository
     * @return void
     */
    public function __construct(private WpRoleRepository $roleRepository)
    {
    }

    /**
     * storeWpRole
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpRole(array $data): JsonResponse 
    {
        $wpRole= $this->roleRepository->create($data);
        return response()->json($wpRole);
    }
    
    /**
     * updateWpRole
     *
     * @param  array $data
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function updateWpRole(array $data, WpRole $wpRole): JsonResponse
    {
        $this->roleRepository->update($wpRole, $data);
        return response()->json($wpRole, 200);
    }
    
    /**
     * deleteWpRole
     *
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function deleteWpRole( WpRole $wpRole): JsonResponse
    {
        $this->roleRepository->delete($wpRole);
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

                $results= WpRole::filter($queryFilters, $request->paginate, $sortValues, $orderValues);
            }            
        }else{
            $results= WpRole::filter($queryFilters, $request->paginate);
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