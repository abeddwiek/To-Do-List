<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\TenantsDataTable;
use App\Models\Tenant;
use App\Models\PermissionGroup;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TenantsController extends Controller
{
    public $tokens;

    public function index(TenantsDataTable $dataTable)
    {
        return $dataTable->render('admin.tenants.index');
    }

    public function edit(Tenant $tenant, Request $request)
    {
        $permissionGroups = PermissionGroup::where('guard_name', 'tenants')->whereHas('permissions')->get();

        return view('admin.tenants.create', ['data' => $tenant,
            'permissionGroups' => $permissionGroups]);
    }
    public function store(Tenant $tenant, Request $request)
    {

        $request->validate(
            [
              'name' => 'required',
              'number_of_users' => 'required',
              'primary_email' => 'required|email||unique:tenants,primary_email,'.$tenant->id,
        ]);

        $tenant->fill($request->all());
        $tenant->lock = $request->has('lock') ? 1 : 0;
        $tenant->save();

        //check if there is user for the tenant, if not create one
        $users = $tenant->users()->whereHas("roles", function($q){ $q->where("name", "Managers"); })->get();

        if($users->count() == 0) {
            $user = User::where('email', $tenant->primary_email)->first();
            if(!$user) {
                $user = new User();
                $user->email = $tenant->primary_email;
                $user->password = Hash::make('Admin@123');
            }

            //create admin
            $name = $tenant->name;

            $user->name = $name;
            $user->save();
            $user->assignRole('Managers');
            $user->tenant_id = $tenant->id;
            $user->active = $tenant->lock;
            $user->save();

            //send email to the user
          //  $email = new TenantWelcome($user);
           // Mail::to($user->email)->send($email);
        }else{
            $user = $users->first();
             User::where('tenant_id', $tenant->id)->update(['active'=> $tenant->lock]);
        }

        $tenant->syncPermissions([]);
        if($request->has('permissions')) {


            foreach($request->permissions as $permission => $value) {
                $oPermission = Permission::find($permission);
                if($oPermission){
                    $tenant->guard(['tenants'])->givePermissionTo($oPermission->name);
                }
            }

            //add web permisstions
            $permissions = Permission::where('guard_name', 'web')->get();
                $user->syncPermissions($permissions);
        }

         return  redirect(route('tenants.index'))->with('message', 'saved');

    }
}
