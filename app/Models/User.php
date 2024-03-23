<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasTenant;
use App\Scopes\TenantScope;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,HasTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'temporary_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */

    public static function booted()
    {
        $currentUser = auth()->user();
        static::addGlobalScope(new TenantScope($currentUser));
        static::creating(function ($model) use($currentUser) {
            if(!is_null($currentUser)) {
                $model->tenant_id = $currentUser->tenant->id;
            }
        });


    }

    public function scopeTenant(Builder $builder)
    {
        return $builder->where('tenant_id', auth()->user()->tenant_id);
    }

    public function AssignedUser()
    {
        return $this->hasMany(ToDo::class, 'assigned_user_id', 'id');
    }



    public function hasPermissionTo($permission, $guardName = null, $groupName = null): bool
    {

        if (auth()->user()->hasRole('Admin')) {
            return true;
        }

        if($guardName == 'tenants') {
            $tenantId = auth()->user()->tenant_id;

            $oPermission = Permission::where('name', $permission)
                ->where('guard_name', $guardName)->first();
            if($oPermission) {
                $checkIfUserHasPermission = ModelHasPermission::where('model_type', Tenant::class)
                    ->where('model_id', $tenantId)
                    ->where('permission_id', $oPermission->id)->first();

                if($checkIfUserHasPermission) {
                    return true;
                }
            }

            return false;
        }

        $group = $groupName;
        $allowedPermission = [];

        switch($permission) {
            case 'Readers' :
                $allowedPermission = ['Readers', 'Editors', 'Managers'];
                break;
            case 'Editors' :
                $allowedPermission = ['Editors', 'Managers'];
                break;

            case 'Managers':
                $allowedPermission = ['Managers'];
                break;
        }

        $oPermission = Permission::whereIn('name', $allowedPermission)
            ->whereHas('Group', function ($q) use ($group) {
                $q->where('name', $group);
            })->get()->pluck('id');

        $checkIfUserHasPermission = ModelHasPermission::where('model_type', User::class)
            ->where('model_id', auth()->user()->id)
            ->whereIn('permission_id', $oPermission)->first();

        if ($checkIfUserHasPermission) {
            return true;
        }

        //check if group has permissions
        $userGroups = UserGroup::where('user_id', auth()->user()->id)->get();
        if($userGroups->count() > 0) {
            $groupIds = $userGroups->pluck('group_id');
            $oPermission = Permission::whereIn('name', $allowedPermission)
                ->whereHas('Group', function ($q) use ($group) {
                    $q->where('name', $group);
                })->get()->pluck('id');

            $checkIfUserHasPermission = ModelHasPermission::where('model_type', Group::class)
                ->whereIn('model_id', $groupIds)
                ->whereIn('permission_id', $oPermission)->first();

            if ($checkIfUserHasPermission) {
                return true;
            }
        }

        return false;
    }



}
