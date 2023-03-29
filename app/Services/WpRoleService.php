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
        $results= WpRole::filter($request->input('filters'),$request->input('sort') ,$request->paginate);

        if(!$request->paginate){
            return  response()->json(["data"=> $results->get()]);
        }else{
            return response()->json($results);
        }
    }
}