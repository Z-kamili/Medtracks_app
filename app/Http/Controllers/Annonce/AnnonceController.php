<?php

namespace App\Http\Controllers\Annonce;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnonceRequest;
use App\Interfaces\Annonce\AnnonceRepositoryInterface;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{


    public $Annonce;


    public function __construct(AnnonceRepositoryInterface $annonce)
    {
        $this->Annonce = $annonce;
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
       return $this->Annonce->index();
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->Annonce->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnonceRequest $request)
    {
        return $this->Annonce->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Annonce->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Annonce->edit($id);
    }

    public function valider($id)
    {
        return $this->Annonce->valider($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAnnonceRequest $request, $id)
    {
        return $this->Annonce->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Annonce->destroy($id);
    }

    public function getannonces()
    {
        return $this->Annonce->getannonces();
    }

    public function getservices($id)
    {
        return $this->Annonce->getservices($id);
    }

    public function getmodalites($id)
    {
        return $this->Annonce->getmodalites($id);
    }

    public function getmetier($id)
    {
        return $this->Annonce->getmetier($id);
    }

    public function latestannonce()
    {
        return $this->Annonce->latestannonce();
    }

    public function getskills($id)
    {
        return $this->Annonce->getskills($id);
    }

    public function get_type($id)
    {
        return $this->Annonce->get_type($id);
    }

    public function get_profession($id)
    {
        return $this->Annonce->get_profession($id);
    }


    public function getannonce_valide() 
    {
         return $this->Annonce->getannonce_valide();
    } 

    public function annonce_valide() 
    {
        return $this-> Annonce->annonce_valide();
    }

    public function all_annonce() 
    {
        return $this->Annonce->all_annonce();
    }

    public function getall_annonce()
    {
        return $this->Annonce->getall_annonce();
    }

    public function Latest_annonce() 
    {
        return $this->Annonce->latestannonce();
    }

    public function Latest_mission() 
    {
        return $this->Annonce->latestmission();
    }

}
