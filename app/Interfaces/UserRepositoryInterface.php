<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function createUser(array $data);
    public function getUserByEmail(string $email);
    public function getUserById (int $userId);
}