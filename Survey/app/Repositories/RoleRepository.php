<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository
{

    protected object $inputs;
    protected object $role;
    public function roles()
    {
        return Role::where('guard_name', 'users')->latest()->paginate(config('setting.LimitPaginate'));
    }

    public function permissions()
    {
        return Permission::latest()->get();
    }

    public function requestInput(object $request) :RoleRepository
    {
        $this->inputs = $request;

        return $this;
    }

    public function modelRole(object $role) :RoleRepository
    {
        $this->role = $role;
        return $this;
    }

    public function store()
    {
        $role = Role::create([
            "name" => $this->inputs->name,
        ]);
        $role->givePermissionTo([$this->inputs->permissions]);
    }
    public function update()
    {
        $this->role->update([
            'name' => $this->inputs->name,

        ]);

        $this->role->syncPermissions($this->inputs->permissions);
    }

    public function getRoleById()
    {
        // Return $role
        return $this->role->where('name', '!=', 'Super Admin')->with(['permissions' => function ($q) {
            $q->select('id');
        }])->findOrFail($this->role->id);
    }
}
