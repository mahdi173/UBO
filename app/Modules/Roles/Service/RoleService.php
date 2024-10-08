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
     * showRole
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse{
        $role= Role::find($id);
        if($role){
            return response()->json(
            $role,
            200
            );
            }
            return response()->json([
            'message' =>' role not found']
            ,404
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
    public function delete($id): JsonResponse{
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
  
        $data=Role::filters(
         
         $request->input('filters'),
         $request->input('sort'),
         $request->paginate);
         if(!$request->paginate){
             return  response()->json(["data"=> $data->get()]);
         }else{
             return response()->json($data);
         }
     }     
     /**
      * restore
      *
      * @param  mixed $id
      * @return JsonResponse
      */
     public function restore (string $id): JsonResponse{
        $record = Role::withTrashed()->findOrFail($id);
        $record->restore();
        return response()->json([
            'message' => 'role restored successfully',
            'data' => $record
        ]);
    }    
    /**
     * showDeletedData
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDeletedData(Request $request): JsonResponse{
        $deletedRecords=Role::onlyTrashed()->filters(
         
            $request->input('filters'),
            $request->input('sort'),
            $request->paginate);
           if(!$request->paginate){
               return  response()->json(["data"=> $deletedRecords->get()]);
           }else{
               return response()->json($deletedRecords);
           }
    }    
    /**
     * count Roles
     *
     * @return void
     */
    public function count()
    {
         return $roles = Role::count();
    }
}
