<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    public function getAllUsers();
    public function getAuthenticatedUser();
    public function createUser(array $data);
    public function getUserById(string $id);
    public function updateUser(string $id, array $data);
    public function deleteUser(string $id);
}
