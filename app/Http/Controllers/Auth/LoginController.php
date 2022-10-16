<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function redirectTo()
    {
        //verified role and redirect to the dahsboard
        switch(Auth::user()->role){
            case 'admin':
                return redirect('/');
                break;
            case 'establishment':
                return redirect('establishment');
                break;
            case 'professional':
                return redirect('professional');
                break;
            default:redirect('/login');
        }
         
    } 
}
