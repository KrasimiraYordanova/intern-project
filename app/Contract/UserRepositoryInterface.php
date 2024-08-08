<?php

namespace App\Contract;

use App\Models\User;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function createUser(array $data);
    public function getUserById(int $id);
    public function updateUser(User $user, array $data);
    public function deleteUser(User $user);
}

