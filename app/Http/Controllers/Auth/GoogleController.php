<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\Employee;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    CONST GOOGLE_TYPE = 'google';

    public function handleGoogleRedirect($session)
    {
        
          session()->put('role',$session);
          return Socialite::driver(Static::GOOGLE_TYPE)->redirect();

    }

    public function handleGoogleCallback(Request $request)
    {

        try{
            //verified if exicted
            $user = Socialite::driver(Static::GOOGLE_TYPE)->stateless()->user();
            $userExisted = User::where('oauth_id',$user->id)->where('oauth_type',Static::GOOGLE_TYPE)->first();
            if( $userExisted ){
                Auth::login($userExisted);
                return redirect()->route('login.role');

            } else {
               //test role user
                $role = session()->get('role');
                // dd($role);
                if($role == 'main' || $role == null || $role == 'null' ){
                    return redirect()->Route('login')->with('error','ce email n\'exist pas');
                }
                //create user 
                DB::beginTransaction();
                // dd($user->avatar);
                $newUser = User::create([
                    'email'=> $user->email,
                    'oauth_id'=>$user->id,
                    'email_verified_at'=> date("Y-m-d H:i:s", strtotime('now')),
                    'role'=> $role,
                    'oauth_type'=> static::GOOGLE_TYPE,
                    'password'=> Hash::make($user->id)
                ]);

                //verified role type and create profils user
                if($role == "establishment")
                { 
                    //creation de l'etablisement
                    $establishment = new Establishment();
                    $establishment->name = 'establishment';
                    $establishment->save();
                    //save employee. 
                    $employee = new Employee();
                    $employee->name = $user->name;
                    $employee->es_id = $establishment->id;
                    $role = Role::get()->first();
                    $employee->role_id = $role->id;
                    $employee->user_id = $newUser->id;
                    $employee->save();
                }else if($role == "professional")
                {
                    $names = explode(" ",$user->name);
                    $professional = new Professional();
                    $professional->user_id = $newUser->id;
                    $professional->first_name = $names[0];
                    $professional->last_name = $names[1];
                    $professional->save();
                }
                //Auth
                DB::commit();
                Auth::login($newUser);
                //redirect
                return redirect()->route('login.role');
               
            }

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'exist deja vous devez ce connecter']);
        }

    }


}
