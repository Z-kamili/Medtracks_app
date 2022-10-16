<?php

namespace App\Repository\Establishment;

use App\Models\Type;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Establishment\ProfilEstablishmentInterface;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;

class EstablishmentRepository implements ProfilEstablishmentInterface
{

    use UploadTrait;

    public function index()
    {
        //recuperate sirt_num.
        $employee = Employee::where('user_id',Auth::user()->id)->with('user','establishment.city.State.Country','role')->get()->first();
        //verified and redirect.
        if (!$employee->establishment->sirt_num){
            $types = Type::all();
            return view('Dashboard.Establishment.auth.inscription',compact('types'));
        }

        return view('Dashboard.Establishment.dashboard',compact('employee'));
    }

    public function create()
    {
        //recuperate sirt_num
        $employee = Employee::where('user_id',Auth::user()->id)->with('user','establishment.city.State.Country','role')->get()->first();
        //verified and redirect
        if (!$employee->establishment->sirt_num) 
        {
            $types = Type::all();
            return view('Dashboard.Establishment.auth.inscription',compact('types'));
        }
        return view('Dashboard.Establishment.dashboard', compact('employee'));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try 
        {
            //save country name
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
            $employee = Employee::where('user_id', Auth::user()->id)->get()->first();
            $Establishment = Establishment::where('id',$employee->es_id)->first();
            $Establishment->name = $request->name;
            $Establishment->sirt_num = $request->sirt_num;
            $Establishment->type_id = $request->type;
            $Establishment->id_city = $city->id;
            $Establishment->dep = $request->departement;
            $Establishment->adress = $request->adress;
            $Establishment->save();
            $employee->name = $request->contact;
            $employee->save();
            //Upload file.
            $this->verifyAndStorageFile($request, 'file', 'Establishment', 'upload_file', Auth::user()->id, 'RIB');
            DB::commit();
            return redirect()->back();
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request)
    {

        //

    }
}
