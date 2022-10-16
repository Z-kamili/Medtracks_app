<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'fileable_id',
    ];

    // public function fileable()
    // {

    //     return $this->morphTo();

    // }

    public function User(){

        return $this->belongsTo('App\Models\File','fileable_id');

    }


}
