<?php

namespace App\Repository\Establishment\agenda;

use App\Interfaces\Establishment\CalendarEsInterface;
use App\Interfaces\Professional\CalendarProfessionalInterface;
use App\Models\Annonce;
use App\Models\Penality;
use App\Models\Planning;
use App\Models\Region;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarEstablishmentRepository implements CalendarEsInterface
{

    public function index()
    {
        return view('Dashboard.Establishment.agenda.calendar');
    }

    public function create()
    {
        // 
    }

    public function store($request)
    {
        // 
    }
    public function  update($request)
    {
        // 
    }

    public function edit($id)
    {
        // 
    }

    public function destroy($id)
    {
        $annonce = Annonce::find($id)->delete();
    }

    public function get_events()
    {


        try{
            $events = [];


            //valider.
            $annonces = DB::table('annonce_professional')
                ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
                ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
                ->join('employees', 'employees.id', '=', 'annonces.emp_id')
                ->join('professions', 'professions.id', '=', 'annonces.profession_id')
                ->where('annonce_professional.valider',true)
                ->where('employees.user_id', Auth::user()->id)
                ->select('annonces.time_start', 'professionals.id as professional_id', 'professionals.first_name as first_name', 'professionals.last_name as last_name', 'annonce_professional.professional_id', 'professions.name as title', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.time_end', 'annonces.desc as desc', 'annonce_professional.valider')
                ->get();
    
    
    
            //valider.
            $annonce_non_valide = DB::table('annonce_professional')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
            ->join('employees', 'employees.id', '=', 'annonces.emp_id')
            ->join('professions', 'professions.id', '=', 'annonces.profession_id')
            ->where('annonce_professional.valider',null)
            ->where('annonces.valider',true)
            ->where('employees.user_id', Auth::user()->id)
            ->select('annonces.time_start', 'professions.name as title', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.time_end', 'annonces.desc as desc', 'annonce_professional.valider')
            ->distinct('annonce_professional.annonce_id')
            ->get();
    
    
            //valider mais null
    
            //valider.
            for ($i = 0; $i < count($annonces); $i++) {
                $dateStart =  $annonces[$i]->start .' '. $annonces[$i]->time_start;
                $dateEnd =  $annonces[$i]->end .' '. $annonces[$i]->time_end;
                $events[$i]['id'] = $annonces[$i]->id;
                $events[$i]['title'] = $annonces[$i]->title;
                $events[$i]['start'] = $dateStart;
                $events[$i]['end'] =  $dateEnd;
                $events[$i]['desc'] =  $annonces[$i]->desc;
                $events[$i]['professional_id'] = $annonces[$i]->professional_id;
                $events[$i]['type']  = 'annonce';
                $events[$i]['first_name'] = $annonces[$i]->first_name;
                $events[$i]['last_name'] = $annonces[$i]->last_name;
            }
    
    
            //annonce
            $j = 0;
            if (count($events) !== 0) {
                $start = count($events);
            } else {
                $start = 0;
            }
    
            $end = (count($annonce_non_valide) + count($events));
    
            for ($i = $start; $i < $end; $i++) {
                $dateStart =  $annonce_non_valide[$j]->start .' '. $annonce_non_valide[$j]->time_start;
                $dateEnd =  $annonce_non_valide[$j]->end .' '. $annonce_non_valide[$j]->time_end;
                $events[$i]['id']    = $annonce_non_valide[$j]->id;
                $events[$i]['title'] = $annonce_non_valide[$j]->title;
                $events[$i]['start'] = $dateStart;
                $events[$i]['end']   = $dateEnd;
                $events[$i]['type']  = 'annonce_non_valider';
                $j++;
            }
            return $events;
        }
        catch (\Exception $e) 
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
