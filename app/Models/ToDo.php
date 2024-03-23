<?php

namespace App\Models;

use App\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ToDo extends Model
{
    use HasFactory, HasTenant;
    protected $table = 'to_dos';
    protected $fillable = [
        'subject',
        'description',
        'date',
        'is_completed',
        'creator_id',
        'assigned_user_id'
    ];




    public function Author()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function AssignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }
}
