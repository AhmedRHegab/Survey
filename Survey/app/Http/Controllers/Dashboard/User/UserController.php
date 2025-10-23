<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\UserStoreRequest;
use App\Http\Requests\Dashboard\User\UserUpdateRequest;
use App\Models\User;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public UserService $userService;
    public RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }// End Construct

    public function index()
    {
        $users = $this->userService->getUsers();
        $roles = $this->roleService->getRoles();
        return view('dashboard.users.index', compact('users', 'roles'));

    }// End Index

    public function store(UserStoreRequest $request):RedirectResponse
    {
        try {
            $this->userService->requestInputs($request)->storeUser();

            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        }
        catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()] );

        }
    }// End Store

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        try {
            $this->userService
                ->userModel($user)
                ->requestInputs($request)
                ->updateUser();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');;
        }
        catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()] );

        }
    }// End Update
}
