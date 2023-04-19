<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTypeRequest;
use App\Repository\RepositoryInterface;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

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
        if ($request->user()->cannot('update', Type::class)) {
            abort(403);
        }
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
        if ($request->user()->cannot('update', Type::class)) {
            abort(403);
        }
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
        if (Gate::denies('delete', Type::findOrFail($id))) {
            abort(403);
        } 
        return $this->repository->delete($id);
    }
}
