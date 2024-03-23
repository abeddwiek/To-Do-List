<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Guard;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;
    protected $table= 'permissions';

    protected $fillable = [
        'name',
        'guard_name',
        'group_id'
    ];

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $permission = static::getPermission(['name' => $attributes['name'], 'guard_name' => $attributes['guard_name'],'group_id'=>$attributes['group_id']]);

        if ($permission) {
            throw PermissionAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    public function Group()
    {
        return $this->belongsTo(PermissionGroup::class,'group_id','id');
    }

}
