<?php

namespace PYB\User\Services;

use PYB\User\Models\User;
use PYB\Role\Repositories\RoleRepo;
use Illuminate\Support\Facades\Hash;
use PYB\User\Http\Requests\AddRoleRequest;

class UserService
{
    public function store($request)
    {
        return User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            //'password' => Hash::make($request->password),
        ]);
    }

    public function update($request, $id)
    {
        return User::query()->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }
    public function addRole($role, $user)
    {
        return $user->assignRole($role);
    }

    public function deleteRole($user, $role)
    {
        return $user->removeRole($role);
    }

}