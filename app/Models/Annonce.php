<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Annonce extends Model
{
    use HasFactory, SoftDeletes;

    //realtion with professional
    public function professionals()
    {
        return  $this->belongsToMany(Professional::class,'annonce_professional','annonce_id','professional_id');
    }

    //relation with modality
    public function Modalities()
    {
        return $this->belongsTo('App\Models\Modality', 'modality_id');
    }

    //relation with profession
    public function profession()
    {
        return $this->belongsTo('App\Models\Profession', 'profession_id');
    }

    //relation with service
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    //relation with establishment 
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'emp_id');
    }

    //relation with establishment 
    public function skills()
    {
        return $this->hasMany('App\Models\Skill', 'annonce_id');
    }

    //relation with types
    public function types()
    {
        return $this->belongsTo('App\Models\Type', 'type_structure');
    }

    //relation with  type_annonces
    public function type_annonces()
    {
        return $this->belongsTo('App\Models\TypeAnnonce','type_annonce');
    }

    //relation with pivote table



}
