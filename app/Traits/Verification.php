<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Profession;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


trait Verification
{

    public function verify(User $user)
    {

        if(!$user->professional->Phone)
        {
            // dd($user->professional->Phone);
            $regions = Region::all();
            $professions = Profession::all();
            return view('Dashboard.User.auth.inscription',compact(['regions','professions','user']));
        }

        // return null;
        
    }
}
