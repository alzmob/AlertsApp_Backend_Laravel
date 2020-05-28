<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'app.dashboard']);

        // create permissions
        Permission::create(['name' => 'app.permissions.index']);
        Permission::create(['name' => 'app.permissions.create']);
        Permission::create(['name' => 'app.permissions.store']);
        Permission::create(['name' => 'app.permissions.show']);
        Permission::create(['name' => 'app.permissions.edit']);
        Permission::create(['name' => 'app.permissions.update']);
        Permission::create(['name' => 'app.permissions.destroy']);
        // Create permission role
        Permission::create(['name' => 'app.roles.index']);
        Permission::create(['name' => 'app.roles.create']);
        Permission::create(['name' => 'app.roles.store']);
        Permission::create(['name' => 'app.roles.show']);
        Permission::create(['name' => 'app.roles.edit']);
        Permission::create(['name' => 'app.roles.update']);
        Permission::create(['name' => 'app.roles.destroy']);
        // create permissions for user table
        Permission::create(['name' => 'app.users.index']);
        Permission::create(['name' => 'app.users.create']);
        Permission::create(['name' => 'app.users.store']);
        Permission::create(['name' => 'app.users.show']);
        Permission::create(['name' => 'app.users.edit']);
        Permission::create(['name' => 'app.users.update']);
        Permission::create(['name' => 'app.users.destroy']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['app.dashboard']);
    }
}
