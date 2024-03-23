<?php

namespace App\Models;

use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class UserHasTenant extends Model
{
    use HasFactory, HasTenant;


    protected $fillable = [
        'user_id',
        'tenant_id',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('UserHasTenant')
            ->logOnlyDirty();
    }

    public function Tenant()
    {
        return $this->belongsTo(Tenant::class,'tenant_id','id');
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
