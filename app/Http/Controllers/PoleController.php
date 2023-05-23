<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePoleRequest;
use App\Repository\RepositoryInterface;
use App\Http\Requests\UpdatePoleRequest;

class PoleController extends Controller
{    
    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct( protected RepositoryInterface $repository)
    {
    }    
   
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request){
        return $this->repository->searchBy($request);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(StorePoleRequest $request)
    {     
        $this->authorize('view');

        return $this->repository->add($request);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     */
    public function show(string $id){
        return $this->repository->show($id);
    }
   
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(UpdatePoleRequest $request, string $id)
    {
        $this->authorize('view');

         return $this->repository->update($request,$id);       
    }

       
    /**
     * destroy
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function destroy(string $id)
    {  
        $this->authorize('view');

        return $this->repository->delete($id);
    }

        
    /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id){
        return $this->repository->restore($id);
    }    
    /**
     * showDeletedData
     *
     * @return void
     */
    public function showDeletedData(Request $request){
        return $this->repository->showDeletedData($request);
    }
}

