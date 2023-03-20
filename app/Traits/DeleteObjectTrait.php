<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait DeleteObjectTrait
{    
    /**
     * deleteRecord
     *
     * @param  mixed $object
     * @return JsonResponse
     */
    public  function deleteRecord($object): JsonResponse{
        $object->delete();
        return response()->json(["msg"=>"Item successfully deleted!"], 200);
    }
}