<?php

namespace App\Interfaces;

interface CrudInterface 
{
    public function getAll();
    public function create(array $data);
    public function update($item, array $data);
    public function delete($item);
}