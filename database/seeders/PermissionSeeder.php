<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // truncate table all the content for permission with guard name web

        Permission::getQuery()->delete();
        PermissionGroup::getQuery()->delete();
        DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE permission_groups AUTO_INCREMENT = 1');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Permission entry


        $permissionGroups = [

            [
                'name' => 'Activities',
                'guard_name' => 'web',
                'child' => [
                    'To-Dos' => [
                        ['name' => 'Readers', 'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Editors', 'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Managers', 'guard_name' => 'web',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Admin Control',
                'guard_name' => 'web',
                'child' => [
                    'Admin Control' => [
                        ['name' => 'Readers', 'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Editors', 'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Managers', 'guard_name' => 'web',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Admin Control',
                'guard_name' => 'tenants',
                'child' => [
                    [
                        'name' => 'User',
                        'guard_name' => 'tenants',
                    ],
                    [
                        'name' => 'Group',
                        'guard_name' => 'tenants',
                    ],
                    [
                        'name' => 'Access control',
                        'guard_name' => 'tenants',
                    ],
                ],
            ],

            [
                'name' => 'Activities',
                'guard_name' => 'tenants',
                'child' => [
                    [
                        'name' => 'To Do',
                        'guard_name' => 'tenants',
                    ],

                ],
            ],
        ];

        foreach ($permissionGroups as $permission) {

            $checkPermissionGroup = PermissionGroup::where('name', $permission['name'])
                ->where('guard_name', $permission['guard_name'])
                ->whereNull('parent_id')->first();

            if (!$checkPermissionGroup) {
                $checkPermissionGroup = new PermissionGroup();
                $checkPermissionGroup->name = $permission['name'];
                $checkPermissionGroup->guard_name = $permission['guard_name'];
                $checkPermissionGroup->save();
            }

            foreach ($permission['child'] as $k => $child) {
                if ($permission['guard_name'] == 'web') {
                    //create subgroup
                    $checkSubPermissionGroup = PermissionGroup::where('name', $k)
                        ->where('guard_name', $permission['guard_name'])
                        ->whereNotNull('parent_id')->first();
                    if (!$checkSubPermissionGroup) {
                        $checkSubPermissionGroup = new PermissionGroup();
                        $checkSubPermissionGroup->name = $k;
                        $checkSubPermissionGroup->guard_name = $permission['guard_name'];
                        $checkSubPermissionGroup->parent_id = $checkPermissionGroup->id;
                        $checkSubPermissionGroup->save();
                    }

                    foreach ($child as $pp) {
                        $checkPermissions = Permission::where('name', $pp['name'])
                            ->where('group_id', $checkSubPermissionGroup->id)
                            ->first();
                        if (!$checkPermissions) {
                            $oPermission = Permission::create([
                                'name' => $pp['name'],
                                'group_id' => $checkSubPermissionGroup->id,
                                'guard_name' => $permission['guard_name'],
                            ]);
                        }
                    }

                } else {
                    $checkPermissions = Permission::where('name', $child['name'])
                        ->where('group_id', $checkPermissionGroup->id)
                        ->where('guard_name', $permission['guard_name'])->first();

                    if (!$checkPermissions) {
                        $oPermission = Permission::create([
                            'name' => $child['name'],
                            'group_id' => $checkPermissionGroup->id,
                            'guard_name' => $child['guard_name'],
                        ]);
                    }
                }


            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
