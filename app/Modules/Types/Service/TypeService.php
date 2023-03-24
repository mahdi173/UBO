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
    public function delete(Request $request , $id): JsonResponse{
        $type = Type::find($id);
        if($type){
        return response()->json(
        $type->delete(),200
        );
        }
        return response()->json([
        'message' =>'not found'
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
        // return Type::where('name', 'like', '%' . $name . '%')->get();
<<<<<<< HEAD
        $data=Type::latest()->filter([
=======
        $data=Type::filter([
>>>>>>> main
         'name'=>$request->name,
         'id'=>$request->id,
         'createdat'=>$request->createdat,
         'updatedat'=>$request->updatedat,
         'deletedat'=>$request->updatedat,
<<<<<<< HEAD
         ])->paginate(10);
=======
        ],
        $request->input('sortby', 'id'), $request->input('sortdirection', 'asc'))->paginate(10);
>>>>>>> main
     
     return response()->json($data);
     }

}