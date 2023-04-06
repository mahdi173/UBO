<?php

namespace App\Modules\Types\Service;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repository\RepositoryInterface;


class TypeService implements RepositoryInterface{
    
     
    /**
     * getAllTypes
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse{
        return response()->json(Type::paginate(10), 200);
    }
    
    /**
     * addType
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse{
        return response()->json(
            Type::create($request->all()),200
        );
    }
     /**
     * showRole
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show( string $id): JsonResponse{
        $type= Type::find($id);
        return response()->json($type);
    }
     
    /**
     * updateType
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function update(Request $request , $id): JsonResponse{
        $type = Type::find($id);
        if($type){
        return response()->json(
        $type->fill($request->post())->save(),200
        );
        }
        return response()->json([
            'message' =>'not found',],404
        );
    }    
     
    /**
     * deleteType
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse{
        $type = Type::find($id);
        if($type){
        return response()->json(
        $type->delete(),
        200
        );
        }
        return response()->json([
        'message' =>'item not found'
        ],404
        );
    }
    
    /**
     * SearchByName
     *
     * @param  mixed $name
     * @return void
     */
    public function searchBy(Request $request){
  
        $data=Type::filters(
            $request->input('filters'),
            $request->input('sort'),
            $request->paginate);
            if(!$request->paginate){
                return  response()->json(["data"=> $data->get()]);
            }else{
                return response()->json($data);
            }
        }
     }


