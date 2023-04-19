<?php

namespace App\Http\Controllers;

use App\Models\Pole;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePoleRequest;
use App\Repository\RepositoryInterface;
use App\Http\Requests\UpdatePoleRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        if ($request->user()->cannot('create', Pole::class)) {
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
    public function update(UpdatePoleRequest $request, string $id)
    {
        if ($request->user()->cannot('update', Pole::class)) {
            abort(403);
        }
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
        if(Auth::user()->cannot('delete', Type::class)){
            abort(403); 
        } 
        return $this->repository->delete($id);
    }
    
    
 
}
