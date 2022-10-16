<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;

class RoleAd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::user()->role == 'admin'){

            return $next($request);
          
        }
        if (Auth::user()->role =='establishment'){

            return redirect()->route('establishment');

        }

        if(Auth::user()->role == 'professional'){

            return redirect()->route('professional');

        }
    }
}
