<?php

namespace App\Modules\Poles\Service;

use App\Models\Pole;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePoleRequest;
use App\Repository\RepositoryInterface;



class PoleService implements RepositoryInterface{
    
    /**
     * getAllPoles
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse{
        return response()->json(Pole::paginate(10), 200);
    }
    
    /**
     * addPole
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse{
        return response()->json(
         Pole::create($request->all()),200
        );
    }


     /**
     * showPole
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse{
        $pole= Pole::find($id);
        return response()->json($pole);
    }
    
    /**
     * updatePole
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function update(Request $request , $id): JsonResponse{
        $pole = Pole::find($id);
        if($pole){
        return response()->json(
        $pole->fill($request->post())->save(),200
        );
        }
        return response()->json([
            'message' =>'not found',],404
        );
    }    
    /**
     * deletePole
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse{
        $pole = Pole::find($id);
        if($pole){
        return response()->json(
        $pole->delete(),200
        );
        }
        return response()->json([
        'message' =>'not found',],404
        );
    }

    public function searchBy(Request $request){
  
        $data=Pole::filters(
         
         $request->input('filters'),
         $request->input('sort'),
         $request->paginate);

        //  ->paginate(10);
        if(!$request->paginate){
            return  response()->json(["data"=> $data->get()]);
        }else{
            return response()->json($data);
        }
     }
}