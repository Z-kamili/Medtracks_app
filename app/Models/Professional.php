<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $date = ['Date_Birth'];

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'Date_Birth',
        'adeli_num',
        'Phone',
        'region_id',
        'profession_id',
        'desc',
        'city'
    ];
    //realtion with professional
    public function Annonce()
    {
        return  $this->belongsToMany(Annonce::class,'annonce_professional','professional_id','annonce_id');
    }
     //relation with user.
     public function user()
     {
        return $this->belongsto('App\Models\User','user_id'); 
     }

     //relation with profession.

     public function profession()
     {
         return $this->belongsTo('App\Models\Profession','profession_id');
     }

     //relation with region

    //  public function region()
    //  {
    //      return $this->belongsTo('App\Models\Region','region_id');
    //  }
     
     //realtion with annonces

     public function annonces()
     {
         return $this->belongsToMany(Annonce::class);
     }

     public function city()
     {
 
         return $this->belongsTo('App\Models\City','id_city');
 
     }


}
