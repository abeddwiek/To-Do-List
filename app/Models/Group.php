<?php

namespace App\Models;

use App\Scopes\TenantScope;
use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, HasTenant;

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

    public function users()
    {
        return $this->hasManyThrough(User::class, UserGroup::class, 'group_id', 'id', 'id', 'user_id');
    }


    public function Tenant()
    {
        return $this->belongsTo(Tenant::class);

    }
}
