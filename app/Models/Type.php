<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    
    public function establishment()
    {
         return $this->hasMany('\App\Models\Establishment', 'type_id');
    }

    // public function 
    public function professions()
    {
        return $this->belongsToMany(Profession::class);
    }

}
