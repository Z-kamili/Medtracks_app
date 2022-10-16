<?php

namespace App\Repository\Annonce\Establishment;

use App\Interfaces\Annonce\Establishment\EsAnnonceManagementInterface;
use App\Models\Annonce;
use App\Models\Establishment;
use App\Models\Professional;
use App\Models\Profession;
use App\Models\TypeAnnonce;
use App\Models\Type;
use App\Models\Employee;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EsAnnonceManagementRepository implements EsAnnonceManagementInterface
{


    public function index()
    {
        $types = TypeAnnonce::get()->all();
        $professions = Profession::get()->all();
        return view('Dashboard.Annonce.establishment.es_annonce',compact(['types','professions']));
    }

    public function create()
    {
       
    }

    public function store($request)
    {
       
    }

    public function show($id)
    {
        $annonce = Annonce::where('id',$id)->with(['professionals','employee','profession','skills'])->firstOrFail();
        return view('Dashboard.Annonce.establishment.missions.mission',compact(['annonce']));
    }

    public function edit($id)
    {
     $annonces = Annonce::FindOrFail($id)->with('profession','Modalities','service','skills','type_annonces','types')->get()->first();
     $type_contrats = TypeAnnonce::get()->all();
     $types = Type::get()->all();
     $professions = Profession::get()->all();
     return view('Dashboard.Annonce.update',compact(['annonces','type_contrats','professions','types']));
    }


    public function update($request,$id)
    {

      
    }

    public function destroy($id)
    {


    }

    public function getesannonces($request)
    {
      
        if($request->status == 'encour'){

            if($request->profession && $request->type){
                $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                ->join('professions','professions.id','=','annonces.profession_id')
                ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                ->where('employees.user_id',Auth::user()->id)
                ->whereNull('deleted_at')
                ->where('type_annonces.id',$request->type)
                ->Where('professions.id',$request->profession)
                ->orderBy('annonces.id','desc')
                ->select('professions.name','annonces.time_start','annonces.valider','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc')
                ->distinct('annonces.id')
                ->get();
            }else if($request->type && $request->profession == null) {
                $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                ->join('professions','professions.id','=','annonces.profession_id')
                ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                ->where('employees.user_id',Auth::user()->id)
                ->whereNull('deleted_at')
                ->where('type_annonces.id',$request->type)
                ->orderBy('annonces.id','desc')
                ->select('professions.name','annonces.time_start','annonces.valider','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc')
                ->distinct('annonces.id')
                ->get();
            }else if($request->type == null && $request->profession){
                $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                ->join('professions','professions.id','=','annonces.profession_id')
                ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                ->where('employees.user_id',Auth::user()->id)
                ->whereNull('deleted_at')
                ->Where('professions.id',$request->profession)
                ->orderBy('annonces.id','desc')
                ->select('professions.name','annonces.time_start','annonces.valider','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc')
                ->distinct('annonces.id')
                ->get();
               
            }else{
                $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                ->join('professions','professions.id','=','annonces.profession_id')
                ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                ->where('employees.user_id',Auth::user()->id)
                ->whereNull('deleted_at')
                ->orderBy('annonces.id','desc')
                ->select('professions.name','annonces.time_start','annonces.valider','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc')
                ->distinct('annonces.id')
                ->get();
            }

        }else{
            $annonce = DB::table('annonces')
            ->join('professions','professions.id','=','annonces.profession_id')
            ->join('employees','annonces.emp_id','=','employees.id')
            ->where('employees.user_id',Auth::user()->id)
            ->whereNull('deleted_at')
            ->orderBy('annonces.id','desc')
            ->select('professions.name','annonces.time_start','annonces.valider','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc')
            ->distinct('annonces.id')
            ->get();
        }
    
        return $annonce;
     
    }

    public function getesmission_enattent($request)
    {
        if($request->status == 'enattente'){
            if($request->type && $request->profession){  
                $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                ->join('professions','professions.id','=','annonces.profession_id')
                ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                ->where('employees.user_id',Auth::user()->id)
                ->where('type_annonces.id',$request->type)
                ->where('pa.valider',null)
                ->whereNull('deleted_at')
                ->where('annonces.deleted_at',null)
                ->Where('professions.id',$request->profession)
                ->orderBy('annonces.id','desc')
                ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                ->distinct('annonce_professional.annonce_id')
                ->get();
            return $annonce;
                }else if($request->type && $request->profession == null) {
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',null)
                    ->whereNull('deleted_at')
                    ->Where('type_annonces.id',$request->type)
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                return $annonce;
                }else if($request->type == null && $request->profession){
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',null)
                    ->whereNull('deleted_at')
                    ->Where('professions.id',$request->profession)
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                }else if( $request->profession && $request->type == 'all') {
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',null)
                    ->whereNull('deleted_at')
                    ->Where('professions.id',$request->profession)
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                }else {
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',null)
                    ->whereNull('deleted_at')
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                }
                return $annonce;
        }else {
            $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
            ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
            ->join('professions','professions.id','=','annonces.profession_id')
            ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
            ->where('employees.user_id',Auth::user()->id)
            ->where('pa.valider',null)
            ->whereNull('deleted_at')
            ->where('annonces.valider',true)
            ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
            ->distinct('annonces.id')
            ->get();
        return $annonce;
        }

      
    }

    public function getesmission_accepte($request)
    {
        if($request->status == 'accepte'){
            if($request->type && $request->profession){  
                $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                ->join('professions','professions.id','=','annonces.profession_id')
                ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                ->where('employees.user_id',Auth::user()->id)
                ->where('type_annonces.id',$request->type)
                ->where('pa.valider',1)
                ->whereNull('deleted_at')
                ->Where('professions.id',$request->profession)
                ->orderBy('annonces.id','desc')
                ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                ->distinct('annonce_professional.annonce_id')
                ->get();
                return $annonce;
            }else if($request->type && $request->profession == null) {
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',1)
                    ->whereNull('deleted_at')
                    ->where('type_annonces.id',$request->type)
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                return $annonce;
                }else if($request->type == null && $request->profession){
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',1)
                    ->whereNull('deleted_at')
                    ->Where('professions.id',$request->profession)
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                }else if( $request->profession && $request->type == 'all') {
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',1)
                    ->whereNull('deleted_at')
                    ->Where('professions.id',$request->profession)
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                }else {
                    $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
                    ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
                    ->join('professions','professions.id','=','annonces.profession_id')
                    ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
                    ->where('employees.user_id',Auth::user()->id)
                    ->where('pa.valider',1)
                    ->whereNull('deleted_at')
                    ->orderBy('annonces.id','desc')
                    ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
                    ->distinct('annonce_professional.annonce_id')
                    ->get();
                }
                return $annonce;
        }else {
            $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
            ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
            ->join('professions','professions.id','=','annonces.profession_id')
            ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
            ->where('employees.user_id',Auth::user()->id)
            ->where('pa.valider',1)
            ->whereNull('deleted_at')
            ->orderBy('annonces.id','desc')
            ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
            ->distinct('annonce_professional.annonce_id')
            ->get();
        return $annonce;
        }

      
    }

    public function get_es_my_annonces($request)
    {
        $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
            ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
            ->join('professions','professions.id','=','annonces.profession_id')
            ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
            ->where('employees.user_id',Auth::user()->id)
            ->where('pa.valider',null)
            ->whereNull('deleted_at')
            ->orderBy('annonces.id','desc')
            ->select('professions.name','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
            ->distinct('annonce_professional.annonce_id')
            ->take(3)
            ->get();
        return $annonce;
    }

    public function get_es_mission_valide()
    {
        $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
        ->join('establishments as es','es.id','=','employees.es_id')
        ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
        ->join('professions','professions.id','=','annonces.profession_id')
        ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
        ->where('employees.user_id',Auth::user()->id)
        ->where('pa.valider',true)
        ->whereNull('pa.finished_at')
        ->orderBy('annonces.id','desc')
        ->select('professions.name as pr_name','es.name as es_name','annonces.price','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
        ->distinct('annonce_professional.annonce_id')
        ->take(3)
        ->get();
        return $annonce;

    }

    public function get_all_es_mission_valide()
    {
        $annonce = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
        ->join('establishments as es','es.id','=','employees.es_id')
        ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
        ->join('professions','professions.id','=','annonces.profession_id')
        ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
        ->where('employees.user_id',Auth::user()->id)
        ->where('pa.valider',1)
        ->whereNull('deleted_at')
        ->orderBy('annonces.id','desc')
        ->select('professions.name as pr_name','es.name as es_name','annonces.price','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
        ->distinct('annonce_professional.annonce_id')
        ->get();
       
        return $annonce;
    }

    public function show_all_mission()
    {
        return view('Dashboard.Annonce.establishment.es_annonce_valider');
    }


    public function get_es_all_mission_valide()
    {
        $annonces = DB::table('annonces')->join('employees','annonces.emp_id','=','employees.id')
        ->join('establishments as es','es.id','=','employees.es_id')
        ->join('annonce_professional as pa','pa.annonce_id','=','annonces.id')
        ->join('professions','professions.id','=','annonces.profession_id')
        ->join('type_annonces','type_annonces.id','=','annonces.type_annonce')
        ->where('employees.user_id',Auth::user()->id)
        ->where('pa.valider',1)
        ->whereNull('deleted_at')
        ->whereNull('pa.finished_at')
        ->orderBy('annonces.id','desc')
        ->select('professions.name as pr_name','es.name as es_name','annonces.price','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','pa.valider')
        ->distinct('annonce_professional.annonce_id')
        ->get();
        return $annonces;
    }

    public function show_announcements_history()
    {
        return view('Dashboard.Annonce.establishment.history.announcements_history');
    }

    public function all_announcements_history()
    {
        //get current date
        $mytime = Carbon::now();
        //update finished_at

        $annonce = DB::table('annonce_professional')
        ->join('annonces','annonces.id','=','annonce_professional.annonce_id')
        ->join('employees','annonces.emp_id','=','employees.id')
        ->where('employees.user_id',Auth::user()->id)
        ->where('annonce_professional.valider',true)
        ->whereDate('annonces.end','<',$mytime->format('Y-m-d'))
        ->update(['finished_at' =>$mytime->format('Y-m-d H:i:s')]);

        //get all announcement history

        $annonce = DB::table('annonce_professional')
        ->join('annonces','annonces.id','=','annonce_professional.annonce_id')
        ->join('employees','annonces.emp_id','=','employees.id')
        ->join('establishments as es','es.id','=','employees.es_id')
        ->join('professions','professions.id','=','annonces.profession_id')
        ->where('employees.user_id',Auth::user()->id)
        ->where('annonce_professional.valider',true)
        ->whereNotNull('finished_at')
        ->orderBy('finished_at','desc')
        ->select('professions.name as pr_name','es.name as es_name','annonces.price','annonces.time_start','annonces.time_end','annonces.id','annonces.start','annonces.end','annonces.desc','annonce_professional.valider')
        ->get();


        return $annonce;        


    }

}