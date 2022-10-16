<?php

namespace App\Repository\Annonce\Establishment;

use App\Events\AnnonceValidated;
use App\Events\RefusedUser;
use App\Events\ValidateUser;
use App\Interfaces\Annonce\Establishment\EsAnnonceManagementInterface;
use App\Interfaces\Annonce\Establishment\ProfilChoiceInterface;
use App\Models\Annonce;
use App\Models\Establishment;
use App\Models\Professional;
use App\Models\Profession;
use App\Models\TypeAnnonce;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProfilChoiceRepository implements ProfilChoiceInterface
{

    use NotificationTrait;

    public function index()
    {
    }

    public function create()
    {
    }

    public function store($request)
    {
    }

    public function show($id)
    {
        $profils = DB::table('annonce_professional')
            ->join('professionals', 'annonce_professional.professional_id', '=', 'professionals.id')
            ->join('users', 'users.id', '=', 'professionals.user_id')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->where('annonce_professional.annonce_id', $id)
            ->select('professionals.id', 'users.status', 'professionals.first_name', 'professionals.last_name', 'professionals.Date_Birth', 'annonce_professional.valider')
            ->orderBy('annonce_professional.id', 'desc')
            ->get();
        return $profils;
    }

    public function edit($id)
    {
        return view('Dashboard.Annonce.establishment.profils.profils-annonce', compact('id'));
    }


    public function update($request)
    {
        //validate annonce
        $annonce = DB::table('annonce_professional')
            ->where('annonce_id', $request->annonce_id)
            ->where('professional_id', $request->user_id)
            ->update(['valider' => 1, 'cleared_at' => null]);

        //no validate others annonces
        $other_annonce = DB::table('annonce_professional')
            ->where('annonce_id', $request->annonce_id)
            ->whereNotIn('professional_id', [$request->user_id])
            ->update(['valider' => 0]);

        //get data
        $user_annonce = DB::table('annonce_professional')
            ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
            ->where('annonce_professional.annonce_id', $request->annonce_id)
            ->where('annonce_professional.professional_id', $request->user_id)
            ->select('annonce_professional.id','professionals.Phone','annonce_professional.annonce_id', 'professionals.user_id')
            ->get()->first();
        //send event and messages
        if ($annonce) 
        {
            event(new ValidateUser($user_annonce));
            $this->notify(
                'email',
                User::find($user_annonce->user_id),
                "Félicitation, Vous êtes approuvé",
                "Vous êtes approuvé! Cliquer sur le lien suivant:",
                ['annonce' => Annonce::find($request->annonce_id)]
            );
            $this->sendSms($user_annonce);
            toastr()->success('Les données ont été enregistrées avec succès!');
            return redirect()->back();
        } 
        else 
        {
            toastr()->error('Déja existe');
            return redirect()->back();
        }
    }



    public function get_profils($id, $annonce)
    {
        $profil = DB::table('annonce_professional')
            ->join('professionals', 'annonce_professional.professional_id', '=', 'professionals.id')
            ->join('annonces', 'annonces.id', '=', 'annonce_professional.annonce_id')
            ->join('users', 'users.id', '=', 'professionals.user_id')
            ->join('cities', 'cities.id', '=', 'professionals.id_city')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->where('annonce_professional.annonce_id', $annonce)
            ->where('professionals.id', $id)
            ->select('professionals.id', 'professionals.first_name', 'cities.name as city', 'countries.name as country', 'professionals.last_name', 'professionals.Date_Birth', 'users.avatar', 'users.status', 'professionals.adresse', 'professionals.adeli_num', 'professionals.Phone', 'annonce_professional.annonce_id', 'annonce_professional.valider')
            ->orderBy('annonce_professional.id', 'desc')
            ->get()
            ->first();

        //files
        $files = Professional::where('id', $id)->with('user.files')->get();

        return view('Dashboard.Annonce.establishment.profils.user-profil', compact(['profil', 'files']));
    }

    public function refuse($professional_id, $annonce_id)
    {
        //refuse annonce.
        $annonce = DB::table('annonce_professional')
            ->where('annonce_id', $annonce_id)
            ->where('professional_id', $professional_id)
            ->update(['valider' => null]);

        //refuse others annonces
        $other_annonce = DB::table('annonce_professional')
            ->where('annonce_id', $annonce_id)
            ->whereNotIn('professional_id', [$professional_id])
            ->update(['valider' => null]);

        //get data.
        $user_annonce = DB::table('annonce_professional')
            ->join('professionals', 'professionals.id', '=', 'annonce_professional.professional_id')
            ->where('annonce_id', $annonce_id)
            ->where('professional_id', $professional_id)
            ->select('annonce_professional.id', 'annonce_professional.annonce_id', 'professionals.user_id')
            ->get()->first();


        //send event and messages.

        if ($annonce) 
        {
            event(new RefusedUser($user_annonce));
            toastr()->success('Les données ont été enregistrées avec succès!');
            return redirect()->back();
        } else {
            toastr()->error('Déja existe');
            return redirect()->back();
        }
    }
}
