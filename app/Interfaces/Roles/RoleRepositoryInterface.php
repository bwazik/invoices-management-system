<?php

namespace App\Interfaces\Roles;

interface RoleRepositoryInterface
{
    public function getAllRoles($request);

    public function addRole($request);

    public function editRole($id);

    public function updateRole($request , $id);

    public function deleteRole($request);

    public function deleteSelectedRoles($request);
}
