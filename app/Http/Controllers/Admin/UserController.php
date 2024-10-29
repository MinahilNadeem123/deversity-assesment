<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //List all users
    public function getUsers()
    {
        $users = User::all();
        $roles = Role::all(); // Assuming you have a Role model
        $permissions = Permission::all(); // Assuming you have a Permission model

        return view('users', ['users' => $users, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function createUser(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Validate each permission
        ]);

        // Update user information
        $request['password'] = Hash::make($request->password);
        $user=$user->create($request->only('name', 'email', 'role_id' , 'password'));

        // Sync permissions (add or remove as needed)
        $user->permission()->sync($request->permissions);

        return redirect()->route('users')->with('success', 'User updated successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // Assuming you have a Role model
        $permissions = Permission::all(); // Assuming you have a Permission model

        return view('edit_user', ['user' => $user, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function update(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Validate each permission
        ]);

        // Update user information
        $user->update($request->only('name', 'email', 'role_id'));

        // Sync permissions (add or remove as needed)
        $user->permission()->sync($request->permissions);

        return redirect()->route('users')->with('success', 'User added successfully!');
    }

    public function deleteUser(User $user){
        $user=$user->delete();
        return redirect()->route('users')->with('success', 'User added successfully!');

    }
}
