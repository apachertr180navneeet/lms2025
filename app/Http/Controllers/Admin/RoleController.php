<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage roles']);
    }

    /**
     * Display all roles
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->where('name', '!=', 'super-admin')
            ->latest()
            ->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Edit role
     */
    public function edit(Role $role)
    {
        if ($role->name === 'super-admin') {
            abort(403);
        }

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'rolePermissions'
        ));
    }

    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'super-admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Delete role
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Super Admin role cannot be deleted');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully');
    }
}
