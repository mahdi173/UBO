<?php

namespace App\Interfaces;

interface WpRoleRepositoryInterface 
{
    public function getAllWpRoles();
    public function createWpRole(string $name);
}