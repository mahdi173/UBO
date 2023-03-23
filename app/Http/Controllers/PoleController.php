<?php

namespace App\Http\Controllers;

use App\Models\Pole;
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
     * @return void
     */
    public function index()
    {
        return $this->repository->getAll();
    }
    
    /**
     * SearchByName
     *
     * @param  mixed $name
     * @return void
     */
    public function searchBy(Request $request){
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
        //$pole=$request->validated();
        return $this->repository->add($request);
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
