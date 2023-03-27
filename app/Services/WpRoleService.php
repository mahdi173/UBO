<?php

namespace App\Services;

use App\Filters\WpRoleFilters;
use App\Models\WpRole;
use App\Repositories\WpRoleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class WpRoleService
{     
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
     * @param  WpRoleFilters $filters
     * @return JsonResponse
     */
    public function filter(WpRoleFilters $filters): JsonResponse
    {
        $results= WpRole::filter($filters);

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