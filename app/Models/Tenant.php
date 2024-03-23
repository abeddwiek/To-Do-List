<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Tenant extends Model
{
    use HasFactory, SoftDeletes, HasRoles, HasApiTokens;

    protected $fillable = ['name', 'description', 'primary_email','number_of_users'];
    protected $guard_name = 'tenants';



    public static function booted()
    {
        $currentUser = auth()->user();
        static::addGlobalScope(new TenantScope($currentUser));
    }


    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id', 'id')->withoutGlobalScope(TenantScope::class);
    }

    public function getActiveUser()
    {
        return $this->users->where('active', 1)->count();
    }





}
