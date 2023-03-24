<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function getAll();
    public function add(Request $request);
    public function update(Request $request,string $id);
    public function delete(Request $request,string $id);
    public function searchBy(Request $request);
}