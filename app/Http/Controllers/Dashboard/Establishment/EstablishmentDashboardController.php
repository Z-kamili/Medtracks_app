<?php

namespace App\Http\Controllers\Dashboard\Establishment;

use App\Models\File;
use App\Models\Type;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\EstablishmentInscriptionRequest;
use App\Interfaces\Establishment\ProfilEstablishmentInterface;

class EstablishmentDashboardController extends Controller
{
    private $Establishment;

    public function __construct(ProfilEstablishmentInterface $ES)
    {

        $this->Establishment = $ES;
        
    }

    public function index()
    {
     return  $this->Establishment->index();
    }

    public function create()
    {
      return  $this->Establishment->create();
    }


    public function store(EstablishmentInscriptionRequest $request)
    {
      return  $this->Establishment->store($request);
    }

    public function update(EstablishmentInscriptionRequest $request)
    {
        
    

    }
}
