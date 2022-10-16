<?php

namespace App\Http\Livewire;

use App\Models\Region;
use App\Models\Profession;
use App\Models\User;
use App\Models\Professional;
use Livewire\WithFileUploads;
use App\Events\StatusChanged;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProfilPs extends Component
{
    use UploadTrait, WithFileUploads;
    public $first_name, $last_name, $country,$code,$countries, $city, $profession, $profession_id, $Date_Birth, $adresse, $Phone, $adeli_num, $region, $cni, $diplome, $ss_num, $rib, $photo, $status, $avatar, $desc, $show = false, $show_profession = false, $error = '', $success_message = '';

    public function mount()
    {
        $this->remplir();
    }

    public function render()
    {
        return view('livewire.professional.profil-ps', [
            'professions' => Profession::all(),
        ]);
    }

    public function updatedPhoto()
    {
        //validation.
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max.
        ]);
        try {
            $user =  User::where('id', Auth::user()->id)->first();
            $user->avatar = $this->photo->getClientOriginalName();
            $user->save();
            $this->photo->storeAs('Professional', $this->photo->getClientOriginalName(), 'upload_file');
            $this->avatar =  $this->photo->getClientOriginalName();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updatedDesc()
    {
        try {
            $professional =  Professional::where('user_id', Auth::user()->id)->first();
            $professional->desc = $this->desc;
            $professional->save();
            $this->desc = $this->desc;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updatedProfessionId()
    {
        try {
            $professional =  Professional::where('user_id', Auth::user()->id)->first();
            $professional->profession_id = $this->profession_id;
            $professional->save();
            $this->profession = Profession::where('id', $this->profession_id)->first();
            $this->profession =  $this->profession->name;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function remplir()
    {
        $professional = Professional::where('user_id', Auth::user()->id)->with('profession', 'city.State.Country', 'user.files')->first();
        $this->first_name = $professional->first_name;
        $this->last_name = $professional->last_name;
        $this->Date_Birth = $professional->Date_Birth;
        $this->adresse = $professional->adresse;
        $this->Phone = $professional->Phone;
        $this->adeli_num = $professional->adeli_num;
        $this->region = $professional->city->State->name;
        $this->country = $professional->city->State->country->name;
        $this->city = $professional->city->name;
        $this->profession = $professional->profession->name;
        $this->profession_id = $professional->profession->id;
        $this->avatar = $professional->user->avatar;
        $this->status = $professional->user->status;
        $this->desc = $professional->user->professional->desc;
        $this->cni = "";
        $this->diplome = "";
        $this->ss_num = "";
        $this->rib = "";
        $this->success_message = '';
    }


    public function changeStatus()
    {
        $user = User::where('id', Auth::user()->id)->get()->first();
        $user->status = !$user->status;
        $this->status = $user->status;
        event(new StatusChanged());
        $user->save();
    }

    public function resetForm()
    {
        $this->remplir();
    }


    public function update()
    {
        //validation
        $this->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "Phone" => 'numeric|min:10|',
            "Date_Birth" => 'required|date|date_format:Y-m-d',
            "adresse" => 'required',
            "adeli_num" => 'numeric|min:10|nullable',
        ]);

        DB::beginTransaction();

        try {
            // dd($this->Date_Birth);
            //update  professional
            $Professional = Professional::where('user_id', Auth::user()->id)->with('user')->first();
            $Professional->first_name = $this->first_name;
            $Professional->last_name = $this->last_name;
            $Professional->Date_Birth = $this->Date_Birth;
            $Professional->adresse = $this->adresse;
            $Professional->Phone = $this->Phone;
            $Professional->adeli_num = $this->adeli_num;
            $Professional->save();
            $this->uploadFile();
            DB::commit();
            return redirect()->back()->with('success_message', 'Post successfully updated.');
            $this->resetForm();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function uploadFile()
    {
        // Upload all  file.
        if ($this->cni) {
            $this->cni->storeAs('Professional', 'cni' . Auth::user()->id . '.' . $this->cni->getClientOriginalExtension(), 'upload_file');
        }
        if ($this->diplome) {
            $this->diplome->storeAs('Professional', 'diplome' . Auth::user()->id . '.' . $this->diplome->getClientOriginalExtension(), 'upload_file');
        }
        if ($this->ss_num) {
            $this->ss_num->storeAs('Professional', 'ss_num' . Auth::user()->id . '.' . $this->ss_num->getClientOriginalExtension(), 'upload_file');
        }
        if ($this->rib) {
            $this->rib->storeAs('Professional', 'RIB' . Auth::user()->id . '.' . $this->rib->getClientOriginalExtension(), 'upload_file');
        }
    }


}
