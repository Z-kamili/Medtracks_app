<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory,HasFactory, Notifiable;

    public function user()
    {
        return $this->belongsto('App\Models\User','user_id'); 
    }

    public function establishment()
    {
        return $this->belongsTo('App\Models\Establishment','es_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }
}
