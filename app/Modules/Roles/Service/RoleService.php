<?php

namespace App\Modules\Roles\Service;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repository\RepositoryInterface;


class RoleService implements RepositoryInterface{
    
       
    /**
     * getAllRoles
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse{
        return response()->json(Role::paginate(10), 200);
    }
       
    /**
     * addRole
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse{
        return response()->json(
            Role::create($request->all()),200
        );
    }
    
      
    /**
     * updateRole
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function update(Request $request , $id): JsonResponse{
        $role = Role::find($id);
        if($role){
        return response()->json(
        $role->fill($request->post())->save(),200
        );
        }
        return response()->json([
            'message' =>'not found',],404
        );
    }    
      
    /**
     * deleteRole
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function delete(Request $request , $id): JsonResponse{
        $role = Role::find($id);
        if($role){
        return response()->json(
        $role->delete(),200
        );
        }
        return response()->json([
        'message' =>'not found',],404
        );
    }
    
    /**
     * SearchByName
     *
     * @param  mixed $name
     * @return void
     */
    public function searchBy(Request $request){
        // return Role::where('name', 'like', '%' . $name . '%')->get();
        $data=Role::filter([
         'name'=>$request->name,
         'id'=>$request->id,
         'createdat'=>$request->createdat,
         'updatedat'=>$request->updatedat,
         'deletedat'=>$request->updatedat,
        ],
        $request->input('sortby', 'id'),
        $request->input('sortdirection', 'asc'))
        ->paginate(10);
     
     return response()->json($data);
     }


}