<?php

namespace App\Models;

use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ModelHasPermission extends Model
{
    use HasFactory,HasTenant;
    public $timestamps = false;
}
