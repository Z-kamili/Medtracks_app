<?php

namespace App\Repository\Professional\agenda;

use App\Interfaces\Professional\CalendarProfessionalInterface;
use App\Models\Penality;
use App\Models\Planning;
use App\Models\Region;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarProfessionalRepository implements CalendarProfessionalInterface
{

    public function index()
    {

        return view('Dashboard.User.agenda.calendar');

    }

    public function create()
    {
        //
    }

    public function store($request)
    {
        try {
            $planning = new Planning();
            $planning->title = $request->title;
            $planning->start = $request->start;
            $planning->end = $request->end;
            $planning->save();
        }
        catch (\Exception $e) {

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
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
        $planning = Planning::findOrFail($id)->delete();
        return response('Event removed successfully!');
    }

    public function get_events()
    {

        $annonces = DB::table('annonce_professional')
            ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('professions', 'professions.id', '=', 'annonces.profession_id')
            ->where('annonce_professional.valider', 1)
            ->where('professionals.user_id', Auth::user()->id)
            ->select('annonces.time_start','annonce_professional.professional_id','professions.name as title', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.time_end', 'annonces.desc as desc', 'annonce_professional.valider')
            ->get();

        //recuperer 
        
        $events = [];
        
        for ($i = 0; $i < count($annonces); $i++) {
            $dateStart =  $annonces[$i]->start .' '. $annonces[$i]->time_start;
            $dateEnd =  $annonces[$i]->end .' '. $annonces[$i]->time_end;
            $events[$i]['id'] = $annonces[$i]->id;
            $events[$i]['title'] = $annonces[$i]->title;
            $events[$i]['start'] =  $dateStart;
            $events[$i]['end'] =  $dateEnd;
            $events[$i]['desc'] =  $annonces[$i]->desc;
            $events[$i]['professional_id'] = $annonces[$i]->professional_id;
            $events[$i]['type']  = 'annonce'; 
        }
        //planning
        $Professional = Professional::where('user_id', Auth::user()->id)->get()->first();
        $planning = Planning::where('professional_id', $Professional->id)->get();
        $j = 0;
        if(count($events) !== 0)
        {
            $start = count($events);

        } else {
            $start = 0;
        }
        $end = (count($planning) + count($events));

        for ($i = $start; $i < $end; $i++) 
        {
            $events[$i]['id']    = $planning[$j]->id;
            $events[$i]['title'] = $planning[$j]->title;
            $events[$i]['start'] = $planning[$j]->start;
            $events[$i]['end']   = $planning[$j]->end;
            $events[$i]['type']  = 'planning'; 
            $j++;

        }

        return $events;
    }

    public function post($request)
    {
        $Professional = Professional::where('user_id', Auth::user()->id)->get()->first();
        $planning = new Planning();
        $planning->title = $request->title;
        $planning->start = $request->start_date;
        $planning->end = $request->end_date;
        $planning->professional_id =  $Professional->id;
        $planning->save();
        return response()->json([
            'data' => $planning,
            'message' => 'Nouvel événement ajouté avec succès!',
            'status' => 'OK'
        ]);
    }

    public function update_annonce($request)
    {
    //refuse annonce
    $annonce = DB::table('annonce_professional')
    ->where('annonce_id',$request->annonce_id)
    ->where('professional_id',$request->professional_id)
    ->update(['valider' => null,'cleared_at' => date("Y-m-d H:i:s", strtotime('now'))]);
    //refuse others annonces
    $other_annonce = DB::table('annonce_professional')
    ->where('annonce_id',$request->annonce_id)
    ->whereNotIn('professional_id',[$request->professional_id])
    ->update(['valider' => null]);
    //add penality.
    $penality = new Penality();
    $penality->professional_id = $request->professional_id;
    $penality->save(); 
    }

    public function update_planning($request)
    {
        try{
            DB::beginTransaction();
            $planning = Planning::where('id',$request->id)->get()->first();
            $planning->title = $request->title;
            $planning->start = $request->start_date;
            $planning->end = $request->end_date;
            $planning->save();
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollback();
        }
    }
}
