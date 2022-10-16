<?php

namespace App\Interfaces\Annonce\Establishment;

interface ProfilChoiceInterface
{

    public function index();

    public function store($request);

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request);

    public function get_profils($id,$annonce);

    public function refuse($id,$professional_id);

 


}