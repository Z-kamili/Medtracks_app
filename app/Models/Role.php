<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'role_id');
    }
}
