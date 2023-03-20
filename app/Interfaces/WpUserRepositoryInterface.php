<?php

namespace App\Interfaces;

interface WpUserRepositoryInterface 
{
    public function getAllWpUsers();
    public function createWpUser(array $data);
}