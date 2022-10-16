<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Establishment extends Model 
{
    use HasFactory, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'Sirt_num',
        'type_id',
    ];

    //relation with employe
    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'es_id');
    }

    public function type()
    {

        return $this->belongsTo('App\Models\Type','type_id');

    }

    public function city()
    {

        return $this->belongsTo('App\Models\City','id_city');

    }



}
