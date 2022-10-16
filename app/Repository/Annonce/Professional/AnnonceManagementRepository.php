<?php

namespace App\Repository\Annonce\Professional;

use App\Interfaces\Annonce\AnnonceManagementInterface;
use App\Models\Annonce;
use App\Models\User;
use App\Models\Establishment;
use App\Events\AnnonceApplied;
use App\Events\RefusedAnnonce;
use App\Models\Penality;
use App\Models\Profession;
use App\Models\Professional;
use App\Traits\AnnonceVerification;
use App\Models\Type;
use App\Models\TypeAnnonce;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AnnonceManagementRepository implements AnnonceManagementInterface
{

    use AnnonceVerification;


    public function index()
    {
        $types = TypeAnnonce::get()->all();
        $professions = Profession::get()->all();
        return view('Dashboard.Annonce.professional.ps_annonce', compact(['types', 'professions']));
    }

    public function create()
    {
        $annonce = DB::table('annonces')
            ->join('employees', 'employees.id', '=', 'annonces.emp_id')
            ->join('professions', 'professions.id', '=', 'annonces.profession_id')
            ->join('professionals', 'professionals.profession_id', '=', 'professions.id')
            ->join('users', 'users.id', '=', 'professionals.user_id')
            ->join('establishments as es', 'es.id', '=', 'employees.es_id')
            ->where('annonces.valider', 1)
            ->where('users.id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->select('annonces.id', 'annonces.price', 'annonces.start', 'annonces.time_start', 'annonces.desc', 'professions.name as pr', 'professions.id as pr_id', 'es.name as es')
            ->orderBy('annonces.id', 'desc')
            ->take(3)
            ->get();
        return $annonce;
    }

    public function store($request)
    {
        //
    }

    public function show($id)
    {
        try {
            $annonce = Annonce::where('id', $id)->with('employee.establishment', 'profession', 'service', 'skills')->get()->firstOrfail();
            $professional = Professional::where('user_id', Auth::user()->id)->get()->first();
            $ps_annonce = Professional::findOrFail($professional->id)->annonces()->where('annonce_id', $id)->get()->first();
            return view('Dashboard.Annonce.postuler', compact(['annonce', 'ps_annonce']));
        } catch (\Exception $e) {

            return abort(404);
        }
    }

    public function edit($id)
    {
    }


    public function update($request)
    {
    }


    public function post($id)
    {
        $verify = false;
        DB::beginTransaction();
        $professional = Professional::where('user_id', Auth::user()->id)->get()->first();
        try {
            //verify data
            $professional_annonce = DB::table('annonce_professional')
                ->where('annonce_professional.annonce_id', $id)
                ->get()->all();
            for ($i = 0; $i < count($professional_annonce); $i++) {
                if ($professional_annonce[$i]->valider == 1) {
                    $verify = true;
                    break;
                }
            }
            //attach professional to her annonce.
            if (!$verify) {
                $professional->annonces()->attach($id);
                DB::commit();
            } else {
                toastr()->error('cette mission et déja occupper');
                return redirect()->back();
            }
            //traitement manipuler
            //employee.
            $annonce = Annonce::where('id', $id)->with('employee')->get()->first();
            event(new AnnonceApplied($annonce));
            toastr()->success('Les données ont été enregistrées avec succès !');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Votre demande a déjà été envoyée');
            return redirect()->back();
        }
    }

    public function getpsannonces($request)
    {
        if ($request->type && $request->profession) {
            $annonce = DB::table('annonces')
                ->join('professions', 'professions.id', '=', 'annonces.profession_id')
                ->join('employees', 'employees.id', '=', 'annonces.emp_id')
                ->join('establishments as es', 'es.id', '=', 'employees.es_id')
                ->where('annonces.valider', 1)
                ->whereNull('deleted_at')
                ->where('annonces.profession_id', $request->profession)
                ->where('annonces.type_annonce', $request->type)
                ->select('annonces.id', 'annonces.price', 'annonces.start', 'annonces.time_start', 'annonces.desc', 'professions.name as pr', 'es.name as es')
                ->orderBy('annonces.id', 'desc')
                ->get();
        } else if ($request->type == null && $request->profession) {
            $annonce = DB::table('annonces')
                ->join('professions', 'professions.id', '=', 'annonces.profession_id')
                ->join('employees', 'employees.id', '=', 'annonces.emp_id')
                ->join('establishments as es', 'es.id', '=', 'employees.es_id')
                ->where('annonces.valider', 1)
                ->whereNull('deleted_at')
                ->where('professions.id', $request->profession)
                ->select('annonces.id', 'annonces.price', 'annonces.start', 'annonces.time_start', 'annonces.desc', 'professions.name as pr', 'es.name as es')
                ->orderBy('annonces.id', 'desc')
                ->get();
        } else if ($request->type && $request->profession == null) {
            $annonce = DB::table('annonces')
                ->join('professions', 'professions.id', '=', 'annonces.profession_id')
                ->join('employees', 'employees.id', '=', 'annonces.emp_id')
                ->join('establishments as es', 'es.id', '=', 'employees.es_id')
                ->where('annonces.valider', 1)
                ->whereNull('deleted_at')
                ->where('annonces.type_annonce', $request->type)
                ->select('annonces.id', 'annonces.price', 'annonces.start', 'annonces.time_start', 'annonces.desc', 'professions.name as pr', 'es.name as es')
                ->orderBy('annonces.id', 'desc')
                ->get();
        } else {
            $annonce = DB::table('annonces')
                ->join('employees', 'employees.id', '=', 'annonces.emp_id')
                ->join('professions', 'professions.id', '=', 'annonces.profession_id')
                ->join('professionals', 'professionals.profession_id', '=', 'professions.id')
                ->join('users', 'users.id', '=', 'professionals.user_id')
                ->join('establishments as es', 'es.id', '=', 'employees.es_id')
                ->where('annonces.valider', 1)
                ->whereNull('deleted_at')
                ->where('users.id', Auth::user()->id)
                ->select('annonces.id', 'annonces.price', 'annonces.start', 'annonces.time_start', 'annonces.desc', 'professions.name as pr', 'es.name as es')
                ->orderBy('annonces.created_at', 'asc')
                ->get();
        }

        return $annonce;
    }

    public function show_all_missions()
    {
        return view('Dashboard.Annonce.professional.ps_mission');
    }

    public function update_mission($id)
    {
        try 
        {
            //get professional id.
            $professional = Professional::where('user_id', Auth::user()->id)->get()->first();
            DB::beginTransaction();
            //refuse annonce.
            $annonce = DB::table('annonce_professional')
                ->where('annonce_id', $id)
                ->where('professional_id', $professional->id)
                ->update(['valider' => null, 'cleared_at' => date("Y-m-d H:i:s", strtotime('now'))]);
            //refuse others annonces.
            $other_annonce = DB::table('annonce_professional')
                ->where('annonce_id', $id)
                ->whereNotIn('professional_id', [$professional->id])
                ->update(['valider' => null]);
            //add penality.
            $penality = new Penality();
            $penality->professional_id = $professional->id;
            $penality->save();
            DB::commit();
            //get annonce refused
            $get_annonce = DB::table('annonce_professional')
            ->join('annonces','annonces.id','=','annonce_professional.annonce_id')
            ->join('employees','employees.id','=','annonces.emp_id')
            ->where('annonce_id',$id)
            ->where('professional_id',$professional->id)
            ->select('employees.user_id')
            ->get()
            ->first();
            //Broadcast event
            event(new RefusedAnnonce($get_annonce));
            //success message 
            toastr()->success('Votre demande a déjà été envoyée');
            return redirect()->route('annonce.ps.missions.show');
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            toastr()->error('error');
            return redirect()->back();
        }
    }

    public function show_missions($id)
    {
        $annonce = Annonce::where('id', $id)->with(['profession', 'skills'])->firstOrFail();
        return view('Dashboard.Annonce.refuse', compact('annonce'));
    }

    public function getpsmissions()
    {
        $mission = DB::table('annonce_professional')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
            ->join('employees', 'annonces.emp_id', '=', 'employees.id')
            ->join('establishments as es', 'es.id', '=', 'employees.es_id')
            ->join('professions', 'professions.id', '=', 'annonces.profession_id')
            ->where('professionals.user_id', Auth::user()->id)
            ->where('annonce_professional.valider', true)
            ->orderBy('annonces.created_at', 'desc')
            ->select('professions.name as pr_name', 'es.name as es_name', 'annonces.price', 'annonces.time_start', 'annonces.time_end', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.desc', 'annonce_professional.valider')
            ->get();


        return $mission;
    }

    public function getmissions()
    {

        $mission = DB::table('annonce_professional')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
            ->join('employees', 'annonces.emp_id', '=', 'employees.id')
            ->join('establishments as es', 'es.id', '=', 'employees.es_id')
            ->join('professions', 'professions.id', '=', 'annonces.profession_id')
            ->where('professionals.user_id', Auth::user()->id)
            ->where('annonce_professional.valider', true)
            ->orderBy('annonces.created_at', 'desc')
            ->select('professions.name as pr_name', 'es.name as es_name', 'annonces.price', 'annonces.time_start', 'annonces.time_end', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.desc', 'annonce_professional.valider')
            ->take(3)
            ->get();

        return $mission;
    }

    public function show_history_and_future_mission()
    {
        return view('Dashboard.Annonce.professional.history_future_mission');
    }


    public function get_future_mission()
    {
        $future_mission = DB::table('annonce_professional')
        ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
        ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
        ->join('employees', 'annonces.emp_id', '=', 'employees.id')
        ->join('establishments as es', 'es.id', '=', 'employees.es_id')
        ->join('professions', 'professions.id', '=', 'annonces.profession_id')
        ->where('professionals.user_id', Auth::user()->id)
        ->where('annonce_professional.valider', null)
        ->where('annonce_professional.finished_at', null)
        ->orderBy('annonces.created_at', 'desc')
        ->select('professions.name as pr_name', 'es.name as es_name', 'annonces.price', 'annonces.time_start', 'annonces.time_end', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.desc', 'annonce_professional.valider')
        ->get();

        return $future_mission;

    }

    public function get_history_mission()
    {
        //update if annonces
        $this->updateAnnonce();
        //get all  historied mission
        $mission_history = DB::table('annonce_professional')
        ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
        ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
        ->join('employees', 'annonces.emp_id', '=', 'employees.id')
        ->join('establishments as es', 'es.id', '=', 'employees.es_id')
        ->join('professions', 'professions.id', '=', 'annonces.profession_id')
        ->where('professionals.user_id', Auth::user()->id)
        ->where('annonce_professional.valider', true)
        ->whereNotNull('annonce_professional.finished_at')
        ->orderBy('annonces.created_at', 'desc')
        ->select('professions.name as pr_name', 'es.name as es_name', 'annonces.price', 'annonces.time_start', 'annonces.time_end', 'annonces.id', 'annonces.start', 'annonces.end', 'annonces.desc', 'annonce_professional.valider')
        ->get();

        return $mission_history;

    }
}
