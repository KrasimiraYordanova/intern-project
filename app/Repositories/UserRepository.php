<?php

declare (strict_types = 1);

namespace App\Repositories;

use App\Contract\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface 
{
    /**
     * @return Collection
     */
    public function getAllUsers() : Collection
    {
        return User::with(['carsAttaches', 'propertiesAttaches'])->get();
        // return User::with(['cars'])->get();
        // return User::all();
    }

    /**
     * @param int $id
     * @return null|User
     */
    public function getUserById(int $id) : ?User
    {
        return User::find($id);
    }

    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data) : User
    {
        return User::create($data);
    }
    
    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data) : User
    {
        $user->update($data);
        return $user;
    }

    /**
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user) : void
    {
        $user->delete();
    }
}
