<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    /**
     * Show users listing
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $roles = Role::all();

        $roleArray = [];

        foreach ($roles as $role) {
            $roleArray[] = ['role' => $role, 'permissions' => count($role->permissions->pluck('name'))];
        }

        return Inertia::render('Roles/Index', ['roles' => $roleArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return Inertia::render('Roles/Create', ['permissions' => $permissions]);
    }

    /**
     * Store the specified resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return Redirect::route('roles')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Inertia\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return Inertia::render('Roles/Edit', ['permissions' => $permissions, ['role' => ['id' => $role->id, 'name' => $role->name, 'permissions' => $role->permissions->pluck('id')]]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'permissions' => ['required', 'array'],
        ]);

        $role->name = $request->name;
        $role->syncPermissions('');
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return Redirect::route('roles')->with('success', 'Role edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return Redirect::route('roles')->with('success', 'Role deleted successfully.');
    }
}
