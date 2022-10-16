<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    public function professional()
    {
        return $this->hasOne('App\Models\Professional', 'user_id');
    }
}
