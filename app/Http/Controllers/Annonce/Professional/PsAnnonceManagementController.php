<?php

namespace App\Http\Controllers\Annonce\Professional;


use App\Http\Controllers\Controller;
use App\Interfaces\Annonce\AnnonceManagementInterface;
use Illuminate\Http\Request;
class PsAnnonceManagementController extends Controller
{


    public $annonce;


    public function __construct(AnnonceManagementInterface $annonce)
    {
        $this->annonce = $annonce;
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return $this->annonce->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return $this->annonce->create();
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
    
    public function post($id)
    {
        return $this->annonce->post($id);
    
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->annonce->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->annonce->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $this->annonce->update_annonce($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }



    public function getpsannonces(Request $request)
    {
        return $this->annonce->getpsannonces($request);
    }

    public function getpsmissions(Request $request)
    {
        return $this->annonce->getpsmissions($request);
    }

    public function getmissions()
    {
        return $this->annonce->getmissions();
    }

    public function show_all_missions()
    {
        return $this->annonce->show_all_missions();
    }

    public function show_missions($id)
    {
        return $this->annonce->show_missions($id);
    }

    public function update_mission($id)
    {
        return $this->annonce->update_mission($id);
    }

    //future and history mission

    public function show_history_and_future_mission()
    {
        return $this->annonce->show_history_and_future_mission();
    }

    //future mission

    public function get_future_mission()
    {
        return $this->annonce->get_future_mission();
    }


    //history mission 

    public function get_history_mission()
    {
        return $this->annonce->get_history_mission();
    }




}
