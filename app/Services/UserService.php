<?php

namespace App\Services;

use App\Repositories\UserRepositories\UserRepository;
class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchAllUsers()
    {
        return $this->userRepository->fetchAllUsers();
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser($data);
    }

    public function updateUser(int $id, array $data)
    {
        return $this->userRepository->updateUser($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->deleteUser($id);
    }

    public function searchUsers(array $filters)
    {
        return $this->userRepository->searchUsers($filters);
    }
}
