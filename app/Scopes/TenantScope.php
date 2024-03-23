<?php

namespace App\Scopes;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class TenantScope implements Scope
{

    public $user;

    public function __construct($currentUser)
    {
        $this->user = $currentUser;
    }

    public function apply(Builder $builder, Model $model)
    {
        if(!$this->user) {
            return $builder;
        }

        $tableName = $model->getTable();

        $getClass = get_class($model);
        $column = 'tenant_id';
        $relation = false;
        $tenantId = auth()->user()->tenant_id;
        //check if the model is tenant
        if($getClass == Tenant::class) {
            $column = 'id';
        }

        //check if the model is has tenant
        if(Schema::hasColumn($tableName, 'tenant_id'))
        {
            $builder = $builder->where($column, $tenantId);
        }
        return $builder;
    }

    public function remove(Builder $builder, Model $model)
    {
        // Not necessary
    }
}
