<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\Establishment;
use Livewire\Component;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProfilEs extends Component
{

    use WithFileUploads;

    public $name,$sirt_num,$password,$city,$country,$contact,$type,$type_id,$status,$photo,$avatar,$show_type = false,$role,$rib,$success_message = '',$show=false,$desc;


    public function mount()
    {
        $this->remplir();
    }

    public function render()
    {
        return view('livewire.establishment.profil-es',[
            'types'=> Type::all(),
        ]);
    }

    public function updatedPhoto()
    {
        //validation.
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
        
        try{
            $user =  User::where('id', Auth::user()->id)->first();
            $user->avatar = $this->photo->getClientOriginalName();
            $user->save();
            $this->photo->storeAs('Establishment', $this->photo->getClientOriginalName(), 'upload_file');
            $this->avatar =  $this->photo->getClientOriginalName();
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updatedDesc()
    {
        try {
            $employee =  Employee::where('user_id',Auth::user()->id)->with('establishment')->first();
            $employee->establishment->desc = $this->desc;
            $employee->establishment->save();
            $this->desc = $this->desc;
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function remplir()
    {
   
        $employee = Employee::where('user_id', Auth::user()->id)->with('establishment.type','establishment.city.State.country','user.files','role')->first();
        $this->name = $employee->establishment->name;
        $this->sirt_num = $employee->establishment->sirt_num;
        $this->contact = $employee->name;
        $this->adress = $employee->establishment->adress;
        $this->role = $employee->role->name;
        $this->phone = $employee->establishment->phone;
        $this->email = $employee->user->email;
        $this->type = $employee->establishment->type->name;
        $this->desc = $employee->establishment->desc;
        $this->avatar = $employee->user->avatar;
        $this->type_id = $employee->establishment->type->id;
        $this->status = $employee->user->status;
        $this->city = $employee->establishment->city->name;
        $this->country = $employee->establishment->city->State->Country->name;
        $this->rib = "";
        $this->password = null;

    }

    public function resetForm()
    {
        $this->remplir();
    }
    
    public function changeStatus()
    {
        $employee = Employee::where('user_id', Auth::user()->id)->get()->first();
        $employee->user->status = !$employee->user->status;
        $this->status = $employee->user->status;
        $employee->user->save();
    }


    public function update()
    {
        
        //validation.
        $this->validate([
                'name' =>  'required',
                'sirt_num' =>  'required|numeric',
                'contact'=> 'required|string',
                'adress'=> 'required|string',
                'email'=>'required|email|string',
                'phone'=>'numeric|min:10',
        ]);

        DB::beginTransaction();

        try {
            //update  professional
            $employee = Employee::where('user_id', Auth::user()->id)->with('user','establishment')->first();
            $employee->establishment->name = $this->name;
            $employee->establishment->sirt_num = $this->sirt_num;
            $employee->name = $this->contact;
            $employee->establishment->adress = $this->adress;
            $employee->establishment->phone = $this->phone;
            $employee->user->email = $this->email;
            if($this->password){
                $user = User::where('id',Auth::user()->id);
                $user->update([
                    'password'=>Hash::make($this->password)
                ]);
            }
            $employee->establishment->save();
            $employee->user->save();
            $employee->save();
            $this->uploadFile();
            DB::commit();
            return redirect()->back()->with('success_message', 'Post successfully updated.');
            $this->resetForm();
        } catch (\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updatedTypeId()
    {
        try {
            $employee =  Employee::where('user_id', Auth::user()->id)->with('establishment')->first();
            $employee->establishment->type_id = $this->type_id;
            $employee->establishment->save();
            $this->type = type::where('id', $this->type_id)->first();
            $this->type =  $this->type->name;
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function uploadFile()
    {
        if ($this->rib) {
            $this->rib->storeAs('Establishment', 'RIB' . Auth::user()->id . '.' . $this->rib->getClientOriginalExtension(), 'upload_file');
        }
    }

    
}
