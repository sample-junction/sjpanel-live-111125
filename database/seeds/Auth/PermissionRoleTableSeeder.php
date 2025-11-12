<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles

        $superAdmin = Role::create(['name' => config('access.users.super_admin_role')]);
        $admin = Role::create(['name' => config('access.users.admin_role')]);
        $executive = Role::create(['name' => config('access.users.executive_role')]);
        $panellist = Role::create(['name' => config('access.users.default_role')]);

        //User Group Permissions - Asc Order
        $panellist_permissions = config('access.users.panellist_permissions');
        $executive_permissions = config('access.users.executive_permissions');
        $admin_permissions = config('access.users.admin_permissions');
        //Extra Beta Permissions
        $beta_permission = ['access_beta_panellist','access_beta_executive', 'access_beta_admin'];

        // Create Permissions
        $permissions = array_merge($panellist_permissions, $executive_permissions, $admin_permissions, $beta_permission);
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //Assign Permissions to Panellists
        $panellist->givePermissionTo($panellist_permissions);
        //Assign Permissions to Executives
        $executive->givePermissionTo($executive_permissions);
        // Assign Permissions to Admin
        $admin->givePermissionTo($admin_permissions);
        // ALWAYS GIVE SUPER ADMIN ROLE ALL PERMISSIONS
        $superAdmin->givePermissionTo(Permission::all());

        $this->enableForeignKeys();
    }
}
