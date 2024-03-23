<?php
namespace App\Traits;

use App\Models\ModelHasRole;
use App\Models\Permission;
use App\Models\User;
use App\Scopes\TenantScope;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

trait CheckAuthTenant {
public function check($access) {
    if(Auth::check()) {

        if(auth()->user()->hasRole('Admin')) {
            return true;
        }

        $group = $this->permissionGroup ;
        $permission = Permission::where('name', $access)
            ->whereHas('Group', function($q) use($group) {
               $q->where('name', $group);
            })->first();

        if($permission) {
            $checkIfUserHasPermission = ModelHasRole::where('model_type', User::class)
                ->where('model_id', auth()->user()->id)
                ->whereHas('Role', function($q) use($permission) {
                    $q->withoutGlobalScopes()->whereHas('RolePermissions', function($q2) use($permission) {
                        $q2->where('permission_id', $permission->id)->withoutGlobalScopes();
                    });
                })->first();

           if($checkIfUserHasPermission) {

               return true;
           }
        }
    }

    throw new AuthenticationException('You need permission to perform this action');
}
}
