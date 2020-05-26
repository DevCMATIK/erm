<?php

use App\Domain\System\Permission\Permission;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions();
        $this->assignPermissions();
    }

    public function assignPermissions()
    {
        $permissions = Permission::get();
        $role = Sentinel::findRoleBySlug('super-admin');

        foreach ($permissions as $permission) {
            foreach(explode(',',$permission->list) as $p) {
                $role->addPermission($permission->slug.'.'.$p);
            }
        }
        $role->save();
    }

    public function createPermissions()
    {
        $permissions = $this->getPermissionsArray();
        foreach($permissions as $p)
        {
            Permission::create([
                'slug' => $p[0],
                'list' => implode(',',$p['permissions'])
            ]);
        }
    }

    public function getPermissionsArray()
    {
        return  [
            [
                'users',
                'permissions' => [
                    'create',
                    'delete',
                    'update',
                    'roles',
                    'permissions',
                    'reset-password',
                    'export'
                ]
            ],
            [
                'roles',
                'permissions' => [
                    'create',
                    'delete',
                    'update',
                    'permissions',
                    'export'
                ]
            ],
            [
                'menus',
                'permissions' => [
                    'create',
                    'delete',
                    'update',
                    'serialize',
                    'export'
                ]
            ],
            [
                'permissions',
                'permissions' => [
                    'create',
                    'delete',
                    'update',
                    'export'
                ]
            ],
            [
                'imports',
                'permissions' => [
                    'create',
                    'delete',
                    'update',
                    'serialize'
                ]
            ],
            [
                'files',
                'permissions' => [
                    'users.delete'
                ]
            ],
            [
                'notifications',
                'permissions' => [
                    'create',
                    'delete',
                    'update'
                ]
            ]
        ];
    }
}
