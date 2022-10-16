<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profil extends Component
{

    use WithFileUploads;

    public $name,$adress,$email,$password,$phone,$photo,$avatar = "",$success_message = '';

    public function mount() 
    {

      //methode.
      $this->remplir();

    }

    public function render()
    {
        return view('livewire.admin.profil');
    }

    public function remplir()
    {
         $admin =  Admin::where('user_id',Auth::user()->id)->with('user')->first();
         $this->name = $admin->name;
         $this->email = $admin->user->email;
         $this->adress = $admin->adress;

         if($admin->Phone) {

            $this->phone = $admin->Phone;

         } else {

            $this->phone = "";

         }
         $this->password = null;
         $this->avatar = $admin->user->avatar;
    }

    public function updatedPhoto() {



         $this->validate([
            'photo' => 'image|max:1024',
         ]);

         try {
            $user = User::where('id',Auth::user()->id)->first();
            $user->avatar = $this->photo->getClientOriginalName();
            $user->save();
            $this->photo->storeAs('Admin',$this->photo->getClientOriginalName(),'upload_file');
            $this->avatar = $this->photo->getClientOriginalName();
         }catch(\Exception $e) {
             return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }

    }

    public function update() 
    {

        //validation 
        $this->validate([
            'name'  => 'required',
            'adress'=> 'required|string',
            'email' => 'required|email|string',
            'phone' => 'numeric|min:10', 
        ]);

        DB::beginTransaction();
        try {
            //update pAdmin
            $admin = Admin::where('user_id',Auth::user()->id)->with('user')->first();
            $admin->name = $this->name;
            $admin->adress = $this->adress;
            $admin->user->email = $this->email;
            $admin->phone = $this->phone;
            if($this->password) {
                 $user = User::where('id',Auth::user()->id);
                 $user->update([
                    'password' => Hash::make($this->password)
                 ]);
            }
            $admin->user->save();
            $admin->save();
            DB::commit();
            return redirect()->back()->with('success_message', 'Post successfully updated.');
        } catch(\Exception $e) {
             DB::rollBack();
             dd($e->getMessage());
             return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        

    }

    public function resetForm()
    {
        $this->remplir();
    }

        


}
