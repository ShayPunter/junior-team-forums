<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up all required roles, permissions and queues for the application to function correctly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('[Forum Setup] Running database migrations...');

        $this->call('migrate');

        $this->info('[Forum Setup] Database migrations completed.');
        $this->info('[Forum Setup] Creating roles...');

        // Create Roles
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
        $default = Role::create(['name' => 'default', 'guard_name' => 'sanctum']);

        $this->info('[Forum Setup] Created Roles');
        $this->info('[Forum Setup] Setting up permissions...');

        $user_admin = Permission::create(['name' => 'users.*', 'guard_name' => 'sanctum']);
        $user_index = Permission::create(['name' => 'users.index', 'guard_name' => 'sanctum']);
        $user_show = Permission::create(['name' => 'users.show', 'guard_name' => 'sanctum']);
        $user_create = Permission::create(['name' => 'users.create', 'guard_name' => 'sanctum']);
        $user_edit = Permission::create(['name' => 'users.edit', 'guard_name' => 'sanctum']);
        $user_update = Permission::create(['name' => 'users.update', 'guard_name' => 'sanctum']);
        $user_delete = Permission::create(['name' => 'users.delete', 'guard_name' => 'sanctum']);

        $roles_admin = Permission::create(['name' => 'roles.*', 'guard_name' => 'sanctum']);
        $roles_index = Permission::create(['name' => 'roles.index', 'guard_name' => 'sanctum']);
        $roles_show = Permission::create(['name' => 'roles.show', 'guard_name' => 'sanctum']);
        $roles_create = Permission::create(['name' => 'roles.create', 'guard_name' => 'sanctum']);
        $roles_edit = Permission::create(['name' => 'roles.edit', 'guard_name' => 'sanctum']);
        $roles_update = Permission::create(['name' => 'roles.update', 'guard_name' => 'sanctum']);
        $roles_delete = Permission::create(['name' => 'roles.delete', 'guard_name' => 'sanctum']);

        $categories_admin = Permission::create(['name' => 'categories.*', 'guard_name' => 'sanctum']);
        $categories_index = Permission::create(['name' => 'categories.index', 'guard_name' => 'sanctum']);
        $categories_show = Permission::create(['name' => 'categories.show', 'guard_name' => 'sanctum']);
        $categories_create = Permission::create(['name' => 'categories.create', 'guard_name' => 'sanctum']);
        $categories_edit = Permission::create(['name' => 'categories.edit', 'guard_name' => 'sanctum']);
        $categories_update = Permission::create(['name' => 'categories.update', 'guard_name' => 'sanctum']);
        $categories_delete = Permission::create(['name' => 'categories.delete', 'guard_name' => 'sanctum']);

        $forums_admin = Permission::create(['name' => 'forums.*', 'guard_name' => 'sanctum']);
        $forums_index = Permission::create(['name' => 'forums.index', 'guard_name' => 'sanctum']);
        $forums_show = Permission::create(['name' => 'forums.show', 'guard_name' => 'sanctum']);
        $forums_create = Permission::create(['name' => 'forums.create', 'guard_name' => 'sanctum']);
        $forums_edit = Permission::create(['name' => 'forums.edit', 'guard_name' => 'sanctum']);
        $forums_update = Permission::create(['name' => 'forums.update', 'guard_name' => 'sanctum']);
        $forums_delete = Permission::create(['name' => 'forums.delete', 'guard_name' => 'sanctum']);

        $admin_view = Permission::create(['name' => 'admin.view', 'guard_name' => 'sanctum']);

        // Assign Permissions
        $default->givePermissionTo($categories_index)->guard(['sanctum']);
        $default->givePermissionTo($categories_show)->guard(['sanctum']);
        $default->givePermissionTo($forums_index)->guard(['sanctum']);
        $default->givePermissionTo($forums_show)->guard(['sanctum']);

        $admin->givePermissionTo($user_admin)->guard(['sanctum']);
        $admin->givePermissionTo($roles_admin)->guard(['sanctum']);
        $admin->givePermissionTo($categories_admin)->guard(['sanctum']);
        $admin->givePermissionTo($forums_admin)->guard(['sanctum']);
        $admin->givePermissionTo($admin_view)->guard(['sanctum']);

        $this->info('[Forum Setup] Permissions setup.');
        $this->info('[Forum Setup] Creating admin user...');

        $password = $this->getRandomString(16);

        // Create an admin user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make($password),
        ]);

        $user->guard(['sanctum'])->assignRole('admin');

        $this->info('[Forum Setup] Created admin user.');
        $this->info('[Forum Setup] Forum installed successfully.');
        $this->info('');
        $this->info('[Forum Setup] Admin User Details: ');
        $this->info('[Forum Setup] Email: admin@admin.com');
        $this->info('[Forum Setup] Password: ' . $password);
        $this->info('[Forum Setup] Login URL: '.env('APP_URL').'/login');

        return Command::SUCCESS;
    }

    /**
     * Generates a random string of defined length
     *
     * @param $n
     * @return string
     */
    function getRandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
