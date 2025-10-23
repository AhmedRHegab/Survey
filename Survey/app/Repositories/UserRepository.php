<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{


    public function users()
    {
        return User::with([
            'roles' => function($q) {
                $q->select(['id','name']);
            },
        ])->latest()->paginate(config('setting.LimitPaginate'));
    }

    public function store($request)
    {
       $user =  User::create([
            'name'      => $request->name,
            'email'     =>  $request->email,
            'password'  => bcrypt($request->password),
            'status'    => $request->status
        ]);
        $user->assignRole($request->roles);
    }// End Store

    public function update($request , $user)
    {
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->filled('password') ? bcrypt($request->password) : $user->password,
            'status'    => $request->status
        ]);
        $user->syncRoles([$request->roles]);
    }// End Update

    public function getUsersWithoutPaginate()
    {
        return User::select(['id', 'name'])->latest()->get();
    }


}
