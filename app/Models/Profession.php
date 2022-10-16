<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

       //relation with files
       public function professional()
       {
            return $this->hasMany('\App\Models\Professional', 'profession_id');
       }

       public function types()
       {
            return $this->belongsToMany(Type::class);
       }

       
}
