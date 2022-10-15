<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = config('role_permissions');

        foreach ($roles as $role_name => $role) {
            $position = (new Position())->findOrCreate($role['position'] ?? $role['name']);
            $createdRole = Role::findOrCreate($role_name, 'web');
            foreach ($role['permissions'] as $permission_name => $permission) {
                $namedPermissions = Arr::map($permission, function ($value) use ($permission_name) {
                    $name = "$permission_name $value";
                    Permission::findOrCreate($name, 'web');
                    return $name;
                });

                $createdRole->givePermissionTo($namedPermissions);
            }

            if ($position->users->count() > 0) {
                foreach ($position->users as $user) {
                    $user->syncRoles($createdRole->name);
                }
            }
        }
    }
}
