<?php

namespace App\Http\Controllers\Annonce\Establishment;

use AnnonceProfessional;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Annonce\Establishment\EsAnnonceManagementInterface;
use App\Models\Establishment;
use App\Models\Annonce;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EsAnnonceManagementController extends Controller
{

    public $es_annonce;


    public function __construct(EsAnnonceManagementInterface $es_annonce)
    {
         $this->es_annonce = $es_annonce;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return $this->es_annonce->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return $this->es_annonce->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->es_annonce->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        return $this->es_annonce->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->es_annonce->destroy($id);
    }

    public function getesannonces(Request $request)
    {
        return $this->es_annonce->getesannonces($request);
    }

    public function  getesmission_enattent(Request $request)
    {
        return $this->es_annonce->getesmission_enattent($request);
    }

    public function  getesmission_accepte(Request $request)
    {
        return $this->es_annonce->getesmission_accepte($request);
    }

    public function get_es_my_annonces(Request $request)
    {
        return $this->es_annonce->get_es_my_annonces($request);  
    }

    public function get_es_mission_valide()
    {
        return $this->es_annonce->get_es_mission_valide();  
    }

    public function get_es_all_mission_valide()
    {
        return $this->es_annonce->get_es_all_mission_valide();  
    }

    public function show_all_mission()
    {
        return $this->es_annonce->show_all_mission();  
    }

    public function show_announcements_history()
    {
        return $this->es_annonce->show_announcements_history();  
    }

    public function all_announcements_history()
    {
        return $this->es_annonce->all_announcements_history();  
    }
}
