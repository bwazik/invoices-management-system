<?php

namespace App\Interfaces\Users;

interface UserRepositoryInterface
{
    public function getAllUsers($request);
    
    public function addUser($request);

    public function editUser($id);

    public function updateUser($request);

    public function deleteUser($request);

    public function deleteSelectedUsers($request);
}
