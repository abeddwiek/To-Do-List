<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasFactory;
    use HasRoles;

    protected $table= 'roles';
    protected $guard_name= 'web';


    protected $fillable = [
        'name',
        'guard_name',
        'tenant_id'
    ];

    public function RolePermissions(){
        return $this->hasMany(ModelHasPermission::class, 'model_id', 'id')->where('model_type', Role::class);
    }



}
