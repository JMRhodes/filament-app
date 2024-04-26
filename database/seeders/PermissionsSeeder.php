<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view tournaments']);
        Permission::create(['name' => 'edit tournaments']);
        Permission::create(['name' => 'delete tournaments']);
        Permission::create(['name' => 'publish tournaments']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'subscriber']);
        $role1->givePermissionTo('view tournaments');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('edit tournaments');
        $role2->givePermissionTo('delete tournaments');
        $role2->givePermissionTo('publish tournaments');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        foreach (User::all() as $user) {
            if ($user->id === 1) {
                $user->assignRole($role3);
            } else {
                $user->assignRole($role1);
            }
        }
    }
}
