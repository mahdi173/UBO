<?php

namespace App\Services;

use App\Models\WpUser;
use App\Repositories\WpUserRepository;
use App\Traits\CreateLogInstanceTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;

class WpUserService
{       
    use CreateLogInstanceTrait;

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
     * getWpUser
     *
     * @param  mixed $request
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function getWpUser(WpUser $wpUser): JsonResponse
    {
        $response= new stdClass();

        $response->user= $this->wpUserRepository->getById($wpUser->id);
        
        return response()->json($response);
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
        $results= WpUser::filter($request->input('filters'),$request->input('sort') ,$request->paginate);

        if(!$request->paginate){
            return  response()->json(["data"=> $results->get()]);
        }else{
            return response()->json($results);
        }
    }
}