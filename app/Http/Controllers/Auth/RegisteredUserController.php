<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Professional;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Dashboard.User.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($request->role == 'establishment') {

            $establishment = new Establishment();
            $establishment->name = 'establishment';
            $establishment->save();

            //save employee. 
            $employee = new Employee();
            $employee->es_id = $establishment->id;
            $employee->name = 'Administrateur';
            $employee->user_id = $user->id;
            $role = Role::get()->first();
            $employee->role_id = $role->id;
            $employee->save();

        } else if ($request->role == 'professional') {

            $professional = new Professional();
            $professional->user_id = $user->id;
            $professional->save();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
