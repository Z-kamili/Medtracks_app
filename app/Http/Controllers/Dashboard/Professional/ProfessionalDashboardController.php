<?php

namespace App\Http\Controllers\Dashboard\Professional;

use App\Models\Region;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfessionalInscriptionRequest;
use App\Interfaces\Establishment\ProfilEstablishmentInterface;
use App\Interfaces\Professional\ProfilProfessionalInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfessionalDashboardController extends Controller
{

    private $Professional;


    public function __construct(ProfilProfessionalInterface $Ps)
    {
        $this->Professional = $Ps;
    }
  

    public function index()
    {
        return $this->Professional->index();
    }

    public function create()
    {
       return $this->Professional->create();
    }


    public function store(ProfessionalInscriptionRequest $request)
    {
        return $this->Professional->store($request);
    }

    public function update(ProfessionalInscriptionRequest $request)
    {

      

    }

    public function edit($id)
    {
       return $this->Professional->edit($id);
    }


}
