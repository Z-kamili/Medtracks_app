<?php

namespace App\Http\Controllers\Annonce\Establishment;

use App\Http\Controllers\Controller;
use App\Interfaces\Annonce\Establishment\ProfilChoiceInterface;
use Illuminate\Http\Request;

class ProfilChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public $annonce_pr;


    public function __construct(ProfilChoiceInterface $annonce_pr)
    {
         $this->annonce_pr = $annonce_pr;
    }

    public function index()
    {
        
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
        return $this->annonce_pr->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->annonce_pr->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       return $this->annonce_pr->update($request);
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

    public function get_profils($id,$annonce)
    {
        return $this->annonce_pr->get_profils($id,$annonce);
    }

    public function refuse($id,$annonce_id)
    {
        return $this->annonce_pr->refuse($id,$annonce_id);
    }
}
