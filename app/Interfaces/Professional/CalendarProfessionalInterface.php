<?php 

namespace App\Interfaces\Professional;

interface CalendarProfessionalInterface 
{

    public function index();

    public function store($request);

    public function create();

    public function update($request);

    public function destroy($id);

    public function edit($id);
    
    public function get_events();

    public function post($request);

    public function update_annonce($request);

    public function update_planning($request);

}