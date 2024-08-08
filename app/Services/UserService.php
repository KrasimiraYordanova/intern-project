<?php

declare (strict_types = 1);

namespace App\Services;

use App\Exceptions\RecordNotFound;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository The user repository instance.
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->userRepository->getAllUsers();
    }

    /**
     * Get a user by their ID.
     *
     * @param int $userId The ID of the user.
     * @return null|User The user object.
     * @throws RecordNotFound If the user is not found.
     */
    public function getById(int $userId): ?User
    {
        $user = $this->userRepository->getUserById($userId);
        if (is_null($user)) {
            throw new RecordNotFound();
        }
        return $user;
    }

    /**
     * Create a new user.
     *
     * @param array $data The data for creating the user.
     * @return User The created user.
     */
    public function create(array $data): User
    {
        $user = $this->userRepository->createUser($data);

        return $user;
    }

    /**
     * Update a user with the given data.
     *
     * @param int $userId The ID of the user to update.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     */
    public function updateSelectedUser(int $userId, array $data): User
    {
        $user = $this->getById($userId);
        $this->userRepository->updateUser($user, $data);

        return $user;
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $userId The ID of the user to delete.
     * @throws RecordNotFound If the user is not found.
     */
    public function deleteSelectedUser(int $userId): void
    {
        $user = $this->getById($userId);
        $this->userRepository->deleteUser($user);
    }
}
