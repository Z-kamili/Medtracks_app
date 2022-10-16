<?php

namespace App\Repository\Annonce;

use App\Events\AnnoncePosted;
use App\Events\AnnonceValidated;
use App\Interfaces\Annonce\AnnonceRepositoryInterface;
use App\Models\Modality;
use App\Models\Profession;
use App\Models\Service;
use App\Models\Annonce;
use App\Models\Skill;
use App\Models\Employee;
use App\Models\Type;
use App\Models\TypeAnnonce;
use App\Traits\AnnonceVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class AnnonceRepository implements AnnonceRepositoryInterface
{

    use AnnonceVerification;

    public function index()
    {
        $annonce = Annonce::with('employee.establishment')->get()->all();
        return view('Dashboard.Annonce.annonce', compact(['annonce']));
    }

    public function create()
    {
        $types = Type::get()->all();
        $type_contrats = TypeAnnonce::get()->all();
        return view('Dashboard.Annonce.create', compact(['types', 'type_contrats']));
    }

    public function store($request)
    {
        $time_start =  Carbon::parse($request->time_start)->format('H:m:s');
        $time_end =  Carbon::parse($request->time_end)->format('H:m:s');
        // Change Format
        DB::beginTransaction();
        $Employee = Employee::where('user_id', Auth::user()->id)->get()->first();
        try {
            //update  establishment.
            $annonce = new Annonce();
            $annonce->price = $request->price;
            $annonce->time_start = $time_start;
            $annonce->start = $request->start;
            $annonce->time_end = $time_end;
            $annonce->end = $request->end;
            if ($request->urgant == "1") {
                $annonce->urgent = 1;
            }
            $annonce->emp_id = $Employee->id;
            $annonce->service_id = $request->service_id;
            $annonce->profession_id = $request->metier_id;
            $annonce->modality_id = $request->modalite_id;
            $annonce->type_annonce = $request->type_contrat;
            $annonce->night_work = $request->nuit;
            $annonce->desc = $request->desc;
            $annonce->type_structure = $request->type_structure;
            $annonce->save();
            if ($request->input('cmpt')) {
                for ($i = 0; $i < count($request->input('cmpt')); $i++) {
                    $skill = new Skill();
                    $skill->name = $request->input('cmpt')[$i];
                    $skill->annonce_id = $annonce->id;
                    $skill->save();
                }
            }

            DB::commit();
            event(new AnnoncePosted($annonce->id));
            toastr()->success('Les données ont été enregistrées avec succès !');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            toastr()->error('Un erreur est survenue, veuillez réessayer plus tard.');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $annonce = Annonce::where('id', $id)->with('employee.establishment', 'profession', 'service', 'skills')->firstOrFail();
        return view('Dashboard.Annonce.valider', compact('annonce'));
    }

    public function edit($id)
    {
        $annonces = Annonce::where('id', $id)->with('profession', 'Modalities', 'service', 'skills', 'type_annonces', 'types')->get()->firstOrFail();
        $type_contrats = TypeAnnonce::get()->all();
        $types = Type::get()->all();
        $professions = Profession::get()->all();
        return view('Dashboard.Annonce.update', compact(['annonces', 'type_contrats', 'professions', 'types']));
    }

    public function valider($id)
    {
        $annonce = Annonce::where('id', $id)->get()->first();
        $annonce->valider = 1;
        $annonce->save();
        event(new AnnonceValidated($annonce));
        toastr()->success('Verification completed successfully!');
        return redirect()->route('admin.annonce');
    }

    public function update($request, $id)
    {
        $time_start = $request->time_start;
        $time_end = $request->time_end;
        $time_start =  Carbon::parse($time_start)->format('H:m:s');
        $time_end =  Carbon::parse($time_end)->format('H:m:s');
        DB::beginTransaction();
        $Employee = Employee::where('user_id', Auth::user()->id)->get()->firstOrFail();
        try {
            //update  establishment.
            $annonce = Annonce::where('id', $id)->get()->firstOrFail();
            $annonce->price = $request->price;
            $annonce->time_start =  $time_start;
            $annonce->start =$request->start;
            $annonce->time_end =  $time_end;
            $annonce->end = $request->end;
            if ($request->urgant == "1") {
                $annonce->urgent = 1;
            } else {
                $annonce->urgent = null;
            }
            $annonce->emp_id = $Employee->id;
            $annonce->service_id = $request->service_id;
            $annonce->profession_id = $request->metier_id;
            $annonce->modality_id = $request->modalite_id;
            $annonce->type_annonce = $request->type_contrat;
            $annonce->night_work = $request->nuit;
            $annonce->desc = $request->desc;
            $annonce->type_structure = $request->type_id;
            $annonce->update();
            //skills
            $skills = Skill::where('annonce_id', $id)->delete();
            if ($request->input('cmpt')) {
                for ($i = 0; $i < count($request->input('cmpt')); $i++) {
                    $skill = new Skill();
                    $skill->name = $request->input('cmpt')[$i];
                    $skill->annonce_id = $annonce->id;
                    $skill->save();
                }
            }

            //finished_at manipulation.

            //trait
            $this->verifyAndUpdated($annonce->id);
            DB::commit();
            event(new AnnoncePosted($annonce->id));
            toastr()->success('Les données ont été enregistrées avec succès!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            toastr()->error('Un erreur est survenue, veuillez réessayer plus tard.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        //soft deleting annonce
        $annonce = Annonce::where('id', $id)->delete();
        $annonce_professional = DB::table('annonce_professional')->where('annonce_id', $id)->delete();
        toastr()->success('L\'annonce a été bien supprimer');
        return redirect()->route('annonce.es');
    }

    public function getannonces()
    {

        $annonce = Annonce::where('valider', null)->with('Modalities', 'employee.establishment', 'profession')->orderBy('id', 'desc')->get()->all();
        return $annonce;
    }

    public function getservices($id)
    {
        $section = Service::where('type_id', $id)->pluck("name", "id");
        return $section;
    }

    public function getmodalites($id)
    {
        $modalite = Modality::where('type_id', $id)->pluck("name", "id");
        return $modalite;
    }

    public function getmetier($id)
    {
        $metier = Profession::whereRelation('types', 'type_id', $id)->pluck("name", "id");
        return $metier;
    }

    public function latestannonce()
    {
        $annonce = Annonce::where('valider', null)->with('Modalities', 'employee.establishment', 'profession')->orderBy('id', 'desc')->take(3)->get()->all();
        return $annonce;
    }

    public function latestmission()
    {
        $annonce = Annonce::where('valider', 1)->with('Modalities', 'employee.establishment', 'profession')->orderBy('id', 'desc')->take(3)->get()->all();
        return $annonce;
    }

    public function getskills($id)
    {
        $skills = Skill::where('annonce_id', $id)->pluck("name");
        return $skills;
    }

    public function get_type($id)
    {
        $type = TypeAnnonce::where('id',$id)->pluck('name')->first();
        return $type;
    }

    public function get_profession($id)
    {
        $profession = Profession::where('id',$id)->pluck('name')->first();
        return $profession;
    }

    public function getannonce_valide(){

        $annonce = Annonce::where('valider', 1)->with('Modalities', 'employee.establishment', 'profession')->orderBy('id', 'desc')->get()->all();
        return $annonce;

    }


    public function annonce_valide(){

        return view('Dashboard.Annonce.annonce_valide');

    }


    public function getall_annonce() {

        $annonce = Annonce::with('Modalities', 'employee.establishment', 'profession')->orderBy('id', 'desc')->get()->all();
        return $annonce;

    }


    public function all_annonce() {

        return view('Dashboard.Annonce.annonce_all');

    }

    // public function Latest_annonce() {
    //     $annonce = Annonce::where('valider',null)->with('Midalities','employee.establishment','profession')->orderBy('id','asc')->get();
    //     return $annonce;

    // }

    public function Latest_mission() {

        $annonce = Annonce::where('valider', 1)->with('Modalities', 'employee.establishment', 'profession')->orderBy('id', 'asc')->get()->all();
        return $annonce;

    }





    


}
