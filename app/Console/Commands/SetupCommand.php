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
        $admin = Role::create(['name' => 'admin']);
        $default = Role::create(['name' => 'default']);

        $this->info('[Forum Setup] Created Roles');
        $this->info('[Forum Setup] Setting up permissions...');

        $user_admin = Permission::create(['name' => 'users.*']);
        $user_index = Permission::create(['name' => 'users.index']);
        $user_show = Permission::create(['name' => 'users.show']);
        $user_create = Permission::create(['name' => 'users.create']);
        $user_edit = Permission::create(['name' => 'users.edit']);
        $user_update = Permission::create(['name' => 'users.update']);
        $user_delete = Permission::create(['name' => 'users.delete']);

        $roles_admin = Permission::create(['name' => 'roles.*']);
        $roles_index = Permission::create(['name' => 'roles.index']);
        $roles_show = Permission::create(['name' => 'roles.show']);
        $roles_create = Permission::create(['name' => 'roles.create']);
        $roles_edit = Permission::create(['name' => 'roles.edit']);
        $roles_update = Permission::create(['name' => 'roles.update']);
        $roles_delete = Permission::create(['name' => 'roles.delete']);

        $categories_admin = Permission::create(['name' => 'categories.*']);
        $categories_index = Permission::create(['name' => 'categories.index']);
        $categories_show = Permission::create(['name' => 'categories.show']);
        $categories_create = Permission::create(['name' => 'categories.create']);
        $categories_edit = Permission::create(['name' => 'categories.edit']);
        $categories_update = Permission::create(['name' => 'categories.update']);
        $categories_delete = Permission::create(['name' => 'categories.delete']);

        $forums_admin = Permission::create(['name' => 'forums.*']);
        $forums_index = Permission::create(['name' => 'forums.index']);
        $forums_show = Permission::create(['name' => 'forums.show']);
        $forums_create = Permission::create(['name' => 'forums.create']);
        $forums_edit = Permission::create(['name' => 'forums.edit']);
        $forums_update = Permission::create(['name' => 'forums.update']);
        $forums_delete = Permission::create(['name' => 'forums.delete']);

        $admin_view = Permission::create(['name' => 'admin.view']);

        // Assign Permissions
        $default->givePermissionTo($categories_index);
        $default->givePermissionTo($categories_show);
        $default->givePermissionTo($forums_index);
        $default->givePermissionTo($forums_show);

        $admin->givePermissionTo($user_admin);
        $admin->givePermissionTo($roles_admin);
        $admin->givePermissionTo($categories_admin);
        $admin->givePermissionTo($forums_admin);
        $admin->givePermissionTo($admin_view);

        $this->info('[Forum Setup] Permissions setup.');
        $this->info('[Forum Setup] Creating admin user...');

        $password = $this->getRandomString(16);

        // Create an admin user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make($password),
        ]);

        $user->assignRole('admin');

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
