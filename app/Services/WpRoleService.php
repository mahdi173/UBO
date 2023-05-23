<?php

namespace App\Services;

use App\Models\WpRole;
use App\Repositories\WpRoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;

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
     * @return mixed
     */
    public function filter(Request $request): mixed
    {
        $response= new stdClass();

        $filter= WpRole::filter($request->input('filters'),$request->input('sort'));

        if(!$request->paginate){
            $response->data= $filter->get();
        }else{
            $response= $filter->paginate($request->paginate);
        }

        return $response;
    }    
 
    
    /**
     * showDeletedData
     *
     * @param  mixed $request
     * @return mixed
     */
    public function showDeletedData(Request $request): mixed{
        $response= new stdClass();

        $deletedRecords=WpRole::onlyTrashed()->filter(

            $request->input('filters'),
            $request->input('sort')
            );
           if(!$request->paginate){
            $response->data= $deletedRecords->get();

           }else{
            $response= $deletedRecords->paginate($request->paginate);
           }

           return $response;
    }

              /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id): JsonResponse{
        
        $record = WpRole::withTrashed()->findOrFail($id);
        $record->restore();
        return response()->json([
            'message' => 'WP Role restored successfully',
            'data' => $record
        ]);
}
}