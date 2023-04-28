<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Http\Request;
use stdClass;

class LogService
{  
    /**
     * filter
     *
     * @param  Request $request
     * @return mixed
     */
    public function filter(Request $request): mixed
    {           
        $response= new stdClass();
        $filter= Log::filter($request->input('filters'),$request->input('sort'));

        if(!$request->paginate){
            $response->data= $filter->get();
        }else{
            $response= $filter->paginate($request->paginate);
        }

        return $response;
    }
}