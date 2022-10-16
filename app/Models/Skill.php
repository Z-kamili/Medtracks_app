<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    public function annonces()
    {
        return $this->belongsTo('App\Models\Skill', 'annonce_id');
    }
}
