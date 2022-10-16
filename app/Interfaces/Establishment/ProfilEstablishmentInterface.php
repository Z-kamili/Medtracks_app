<?php
namespace App\Interfaces\Establishment;

interface ProfilEstablishmentInterface 
{

    public function index();

    public function store($request);

    public function create();

    public function update($request);

    
}