<?php

namespace App\Services\Role;

use App\Repositories\RoleRepository;

class RoleService
{
    public RoleRepository $roleRepository;
    protected object $inputs;
    protected object $role;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }// End Construct

    public function getRoles()
    {
        return $this->roleRepository->roles();
    }// End GetRoles

    public function getPermissions()
    {
        return $this->roleRepository->permissions();
    }

    public function requestInput(object $request) :RoleService
    {
        $this->inputs = $request;

        return $this;
    }

    public function modelRole(object $role) :RoleService
    {
        $this->role = $role;
        return $this;
    }

    public function storeRole()
    {
        $this->roleRepository->requestInput($this->inputs)->store();
    }

    public function getRoleById()
    {
       return $this->roleRepository->modelRole($this->role)->getRoleById();
    }

    public function rolePermissions(): array
    {
        // Push The Permission of role into empty array to show the user which permission belongs to role
        $rolePermissions = [];

        foreach ($this->role->permissions as $permission) {
            $rolePermissions[] = $permission->id;
        }
        return $rolePermissions;

    }

    public function updateRole()
    {
        $this->roleRepository->modelRole($this->role)->requestInput($this->inputs)->update();
    }
}
