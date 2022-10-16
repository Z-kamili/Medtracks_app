<?php

namespace App\Repository\Admin;

use App\Interfaces\Admin\AdminRepositoryInterface;
use App\Models\User;
use App\Models\Annonce;
use Illuminate\Support\Facades\Auth;

class AdminRepository implements AdminRepositoryInterface
{


    public function index()
    {
        $user = User::where('id',Auth::user()->id)->with('admin')->get()->first();
        $annonce = Annonce::where('valider',null)->with('employee.establishment')->get()->all();
        return view('Dashboard.Admin.dashboard',compact(['user','annonce']));
    }

    public function create()
    {
        $user = User::where('id',Auth::user()->id)->with('admin')->get()->first();
        $annonce = Annonce::with('employee.establishment')->get()->all();
        return view('Dashboard.Admin.dashboard',compact(['user','annonce']));
    }

    public function store($request)
    {

    }

    public function update($request)
    {

        
      
    }
}