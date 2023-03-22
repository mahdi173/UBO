<?php

namespace App\Interfaces;

interface RoleRepositoryInterface 
{
    public function getRoleByName(string $name);
}