<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


trait AnnonceVerification
{

    public function verifyAndUpdated($id)
    {

        $mytime = Carbon::now();
        //update finished_at
        $history = DB::table('annonce_professional')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('employees', 'annonces.emp_id', '=', 'employees.id')
            ->where('employees.user_id', Auth::user()->id)
            ->where('annonces.id',$id)
            ->where('annonce_professional.valider', true)
            ->whereDate('annonces.end', '>', $mytime->format('Y-m-d'))
            ->update(['finished_at' => null]);
        //update finished_at
        $history = DB::table('annonce_professional')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('employees', 'annonces.emp_id', '=', 'employees.id')
            ->where('employees.user_id', Auth::user()->id)
            ->where('annonces.id', $id)
            ->where('annonce_professional.valider', true)
            ->whereDate('annonces.end', '<', $mytime->format('Y-m-d'))
            ->update(['finished_at' => $mytime->format('Y-m-d H:i:s')]);

        
    }

    public function updateAnnonce()
    {
        $mytime = Carbon::now();
        $history = DB::table('annonce_professional')
        ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
        ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
        ->where('professionals.user_id', Auth::user()->id)
        ->where('annonce_professional.valider', true)
        ->whereDate('annonces.end', '<', $mytime->format('Y-m-d'))
        ->update(['finished_at' => $mytime->format('Y-m-d H:i:s')]);

    }
}