<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Repository\RepositoryInterface;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct(protected RepositoryInterface $repository)
    {
       
    }    
   
        
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request){
        return$this->repository->searchBy($request);
    }

    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->repository->add($request);
    }

    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        return $this->repository->update($request,$id);
    }

        
    /**
     * destroy
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function destroy(Request $request,string $id)
    {
        return $this->repository->delete($request,$id);
    }
}
