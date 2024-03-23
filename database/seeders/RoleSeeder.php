<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::getQuery()->delete();
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');


        // Create Super Admin Role
        $SuperAdminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        if (!$SuperAdminRole) {
            $SuperAdminRole = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        }

         //check all Permissions depends on web
         $SuperAdminPermissions = Permission::where('guard_name', 'web')->get();

         foreach ($SuperAdminPermissions as $SuperAdminPermission) {
             $roles = $SuperAdminRole->guard(['web'])->givePermissionTo($SuperAdminPermission->id);
         }

         // Create  Admin Role
         $adminRole = Role::where('name', 'Managers')->where('guard_name', 'web')->first();

         if (!$adminRole) {
             $adminRole = Role::create(['name' => 'Managers', 'guard_name' => 'web']);
         }

         //check all Permissions depends on web
         $AdminPermissions = Permission::where('guard_name', 'web')->get();

         foreach ($AdminPermissions as $AdminPermission) {

             $roles = $adminRole->guard(['web'])->givePermissionTo($AdminPermission->id);
         }


         // Create  Manager Role
         $managerRole = Role::where('name', 'Editors')->where('guard_name', 'web')->first();

         if (!$managerRole) {
             $managerRole = Role::create(['name' => 'Editors', 'guard_name' => 'web']);
         }

         //get all permission that has name Manage
         $managerPermissions = Permission::where('guard_name', 'web')->whereIn('name', ['Create', 'Update', 'Delete', 'View'])->get();

         foreach ($managerPermissions as $managerPermission) {
             $managerRole->guard(['web'])->givePermissionTo($managerPermission->id);
         }



         // Create  Viewer Role
         $viewerRole = Role::where('name', 'Readers')->where('guard_name', 'web')->first();

         if (!$viewerRole) {
             $viewerRole = Role::create(['name' => 'Readers', 'guard_name' => 'web']);
         }
         //get all permission that has name Edit
         $viewerPermissions = Permission::where('guard_name', 'web')->where('name', 'View')->get();

         foreach ($viewerPermissions as $viewerPermission) {

             $viewerRole->guard(['web'])->givePermissionTo($viewerPermission->id);
         }


         $user = User::where('email', 'superadmin@admin.net')->first();

         if(!$user) {
             $password = env('APP_SUPER_ADMIN_DEFAULT_PASSWROD');
             if(is_null($password)) {
                 $password = 'Admin@123';
             }

             $tenant = Tenant::orderBy('id')->first();
             $user = new User();
             $user->email = 'superadmin@admin.net';
             $user->name = 'Super Admin';
             $user->password = \Illuminate\Support\Facades\Hash::make($password);
             $user->tenant_id = $tenant->id;
             $user->save();
         }

         $user->syncRoles(['Admin']);

         echo 'Finished Process';


    }
}
