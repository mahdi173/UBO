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
        if($pole){
            return response()->json(
            $pole,
            200
            );
            }
            return response()->json([
            'message' =>' pole not found']
            ,404
            );
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
    
    /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id): JsonResponse{
        
            $record = Pole::withTrashed()->findOrFail($id);
            $record->restore();
            return response()->json([
                'message' => 'pole restored successfully',
                'data' => $record
            ]);
    }    
    /**
     * showDeletedData
     *
     * @return void
     */
    public function showDeletedData(Request $request): JsonResponse{
        $deletedRecords=Pole::onlyTrashed()->filters(
         
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
     * count Poles
     *
     * @return void
     */
    public function count()
    {
       return $poles = Pole::count();
    }
    
    
 /**
     * SitesPerPole
     *
     * @return void
     */
    public function SitesPerPole(){
        $poles = Pole::withCount('wpSites')
        ->orderBy('wp_sites_count', 'desc')
        ->take(5)
        ->get();
        return $poles;
    }
}