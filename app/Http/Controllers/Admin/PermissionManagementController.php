<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.permissions.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['roles.permissions', 'permissions']);

        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');

        $directPermissionIds = $user->permissions->pluck('id')->toArray();
        $rolePermissionIds = $user->roles
            ->flatMap(fn ($role) => $role->permissions)
            ->pluck('id')
            ->unique()
            ->toArray();

        return view('admin.permissions.show', compact(
            'user',
            'permissions',
            'directPermissionIds',
            'rolePermissionIds'
        ));
    }

    public function sync(Request $request, User $user)
    {
        $permissionIds = $request->input('permissions', []);

        $user->permissions()->sync($permissionIds);

        return redirect()
            ->route('admin.permissions.show', $user->id)
            ->with('success', 'Permissions updated successfully.');
    }
}