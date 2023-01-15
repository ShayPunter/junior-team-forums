<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'roles');
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
            $roleArray[] = ['role' => $role, 'permissions' => $role->permissions->count()];
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
        return Inertia::render('Roles/Create');
    }

    /**
     * Store the specified resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'role' => ['string'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $role = strtolower($request->role);

        if ($this->roleExist($role)) {
            $user->assignRole($role);
        } else {
            $user->assignRole('default');
        }

        return Redirect::route('users')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['user' => $user, 'role' => $user->getRoleNames()[0]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['string'],
        ]);

        if ($request->email !== $user->email) {
            $user->update($request->all());
        } else {
            $user->name = $request->name;
            $user->update();
        }

        foreach ($user->getRoleNames() as $role) {
            $user->removeRole($role);
        }

        $role = strtolower($request->input('role'));

        if ($this->roleExist($role)) {
            $user->assignRole($role);
        } else {
            $user->assignRole('default');
        }

        return Redirect::route('users')->with('success', 'User edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return Redirect::route('users')->with('success', 'User deleted successfully.');
    }
}
