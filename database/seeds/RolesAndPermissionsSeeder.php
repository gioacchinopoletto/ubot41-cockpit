<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'Administer roles & permissions']);
        Permission::create(['name' => 'Permission - add']);
        Permission::create(['name' => 'Permission - delete']);
        Permission::create(['name' => 'Permission - edit']);
        Permission::create(['name' => 'Role - add']);
        Permission::create(['name' => 'Role - delete']);
        Permission::create(['name' => 'Role - edit']);
        Permission::create(['name' => 'Role - view']);
        Permission::create(['name' => 'User - add']);
        Permission::create(['name' => 'User - add single permission']);
        Permission::create(['name' => 'User - change state']);
        Permission::create(['name' => 'User - delete']);
        Permission::create(['name' => 'User - edit']);
        Permission::create(['name' => 'User - view']);
        Permission::create(['name' => 'User - view profile']);
        
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());
        
        $user = User::where('email', 'dummy@dummy.com')->first();
        $user->assignRole('Admin');
        
    }
}
