<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'email_verified_at',
        'role',
        'oauth_id',
        'oauth_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relation with establishment profile.

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'user_id');
    }

    //relation with professional  profile.

    public function professional()
    {
        return $this->hasOne('App\Models\Professional', 'user_id');
    }

    //relation with files.

    public function files()
    {
        return $this->hasMany('\App\Models\File', 'fileable_id');
    }

    //relation with users 
    
    public function admin()
    {
        return $this->hasOne('App\Models\Admin','user_id');
    }
}
