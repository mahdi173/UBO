<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTypeRequest;
use App\Repository\RepositoryInterface;
use App\Http\Requests\UpdateTypeRequest;

class TypeController extends Controller
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
    public function store(StoreTypeRequest $request)
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
    public function update(UpdateTypeRequest $request, string $id)
    {
        $this->authorize('view');

        return $this->repository->update($request,$id);
    }
        
    /**
     * destroy
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return voids
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
     * @param  mixed $request
     * @return void
     */
    public function showDeletedData(Request $request){
        return $this->repository->showDeletedData($request);
    }
}
