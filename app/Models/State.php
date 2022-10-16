<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function Country()
    {

        return $this->belongsTo('App\Models\Country','country_id');

    }
}
