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

        // Create Permissions
        $server_admin = Permission::create(['name' => 'servers.*']);
        $server_index = Permission::create(['name' => 'servers.index']);
        $server_show = Permission::create(['name' => 'servers.show']);
        $server_create = Permission::create(['name' => 'servers.create']);
        $server_edit = Permission::create(['name' => 'servers.edit']);
        $server_update = Permission::create(['name' => 'servers.update']);
        $server_delete = Permission::create(['name' => 'servers.delete']);

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

        // Assign Permissions
        $default->givePermissionTo($server_index);
        $default->givePermissionTo($server_show);
        $default->givePermissionTo($server_create);
        $default->givePermissionTo($server_edit);
        $default->givePermissionTo($server_update);
        $default->givePermissionTo($server_delete);

        $admin->givePermissionTo($server_admin);
        $admin->givePermissionTo($user_admin);
        $admin->givePermissionTo($roles_admin);

        $this->info('[Forum Setup] Permissions setup.');
        $this->info('[Forum Setup] Creating admin user...');

        // Create an admin user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('superadminpassword'),
        ]);

        $user->assignRole('admin');

        $this->info('[Forum Setup] Created admin user.');
        $this->info('[Forum Setup] Forum installed successfully.');
        $this->info('');
        $this->info('[Forum Setup] Admin User Details: ');
        $this->info('[Forum Setup] Email: admin@admin.com');
        $this->info('[Forum Setup] Password: superadminpassword');
        $this->info('[Forum Setup] Login URL: ' . env('APP_URL') . '/login');

        return Command::SUCCESS;
    }
}
