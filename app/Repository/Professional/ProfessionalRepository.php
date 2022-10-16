<?php 
namespace App\Repository\Professional;

use App\Models\Region;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Professional\ProfilProfessionalInterface;
use App\Traits\Verification;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Carbon\Carbon;

class ProfessionalRepository implements ProfilProfessionalInterface
{
    use UploadTrait,Verification;

    public function index()
    {
        $user = User::where('id', Auth::user()->id)->with('professional.profession','files')->first();
        if(!$user->professional->Phone)
        {
            $professions = Profession::all();
            return view('Dashboard.User.auth.inscription',compact(['professions','user']));
        }
        return view('Dashboard.User.dashboard',compact('user'));
    }

    public function create()
    {
        //recuperate sirt_num.
        $user = User::where('id', Auth::user()->id)->with('professional.profession','professional.city.State.Country','files')->first();
        if(!$user->professional->Phone)
        {
            $professions = Profession::all();
            return view('Dashboard.User.auth.inscription',compact(['professions','user']));
        }
        //redirect
        return view('Dashboard.User.dashboard',compact('user'));
    }
    public function store($request)
    {

        DB::beginTransaction();

        $collections = collect(['cni','diplome','ss_num','RIB']);


        try {
            //ve country name
            $country = new Country();
            $country->name = $request->country;
            $country->save();
            //save state with country id
            $state = new State();
            $state->name = $request->region;
            $state->country_id = $country->id;
            $state->save();
            //save city with state id
            $city = new City();
            $city->name = $request->city;
            $city->state_id = $state->id;
            $city->save();
            //update  establishment
            $Professional = Professional::where('user_id', Auth::user()->id)->with('user')->first();
            $Professional->first_name = $request->first_name;
            $Professional->last_name = $request->last_name;
            $Professional->Date_Birth = $request->Date_Birth;
            $Professional->adresse = $request->adresse;
            $Professional->Phone = $request->Phone;
            $Professional->adeli_num = $request->adeli_num;
            $Professional->id_city = $city->id;
            $Professional->profession_id = $request->profession;
            $Professional->dep = $request->departement;
            $Professional->save();
            //Upload all  file
            foreach($collections as $collection){

                $this->verifyAndStorageFile($request, $collection , 'Professional' , 'upload_file' ,  Auth::user()->id ,$collection);

            }

            DB::commit();

            return redirect()->back();

        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function  update($request)
    {
      
    }

    public function edit($id)
    {
     
    }

    public function destroy($id)
    {




    }


}