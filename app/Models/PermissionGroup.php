<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PermissionGroup extends Model
{
    use HasFactory;
    protected $table = 'permission_groups';
    protected $fillable= ['name','guard_name'];



    public function permissions(){
        return $this->hasMany(Permission::class,'group_id','id');
    }

    public function Children()
    {
        return $this->hasMany(PermissionGroup::class, 'parent_id', 'id');
    }
}
