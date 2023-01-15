<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Show users listing
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::all();

        $userArray = [];

        foreach ($users as $user) {

            $roles = '';

            foreach ($user->getRoleNames() as $role) {
                $roles .= $role . ", ";
            }

            $userArray[] = ['user' => $user, 'role' => substr(trim($roles), 0, -1)];
        }

        return Inertia::render('Users/Index', ['users' => $userArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create');
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
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * Checks if a role exists
     *
     * @param $role_name
     * @return bool
     */
    private function roleExist($role)
    {
        return \Spatie\Permission\Models\Role::where('name', '=', $role)->count() > 0;
    }
}
