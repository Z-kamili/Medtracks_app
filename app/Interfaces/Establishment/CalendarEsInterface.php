<?php
namespace App\Interfaces\Establishment;

interface CalendarEsInterface 
{

    public function index();

    public function store($request);

    public function create();

    public function update($request);

    public function get_events();

    public function destroy($id);



    
}