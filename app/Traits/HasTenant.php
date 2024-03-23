<?php

namespace App\Traits;

use App\Models\ModelHasTenant;
use App\Models\Tenant;
use App\Models\User;

trait HasTenant
{
    public function Tenant()
    {
        return $this->belongsTo(Tenant::class);
    }


}
