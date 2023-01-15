<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Spatie\Permission\Traits\HasRoles;

class InjectUserRole extends Middleware
{
    use HasRoles;

    public function share(Request $request)
    {
        return array_merge(parent::share($request), [

            // Synchronously
            'user.role' => $request->user()->getRoleNames(),

        ]);
    }
}
