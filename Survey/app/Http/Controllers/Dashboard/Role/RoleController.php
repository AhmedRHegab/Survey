<?php

namespace App\Http\Controllers\Dashboard\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Roles\RoleStoreRequest;
use App\Http\Requests\Dashboard\Roles\RoleUpdateRequest;
use App\Services\Role\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
   public RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService =$roleService;
        $this->middleware('permission:role_access', ['only' => ['index']]);
        $this->middleware('permission:role_create', ['only' => ['store', 'create']]);
        $this->middleware('permission:role_edit', ['only' =>   ['update','edit']]);
    }// End Construct

    public function index()
    {
        $roles = $this->roleService->getRoles();
        return view('dashboard.roles.index', compact('roles'));
    }// End Index

    public function create()
    {
        $permissions =  $this->roleService->getPermissions();
        return view('dashboard.roles.create',compact('permissions'));
    }// End Create

    public function store(RoleStoreRequest $request) :RedirectResponse
    {
        try {
            $this->roleService->requestInput($request)->storeRole();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        }
        catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()] );

        }
    }// End Store

    public function edit(Role $role)
    {
        $role=  $this->roleService->modelRole($role)->getRoleById();
        $permissions =  $this->roleService->getPermissions();
        $rolePermissions = $this->roleService->requestInput($role)->rolePermissions();
        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }// End Edit

    public function update(RoleUpdateRequest $request, Role $role) : RedirectResponse
    {
        try {
            $this->roleService->requestInput($request)->modelRole($role)->updateRole();

            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        }
        catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()] );

        }
    }// End Update

    public function destroy()
    {

    }// End Destroy
}
