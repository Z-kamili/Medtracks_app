<?php 

namespace App\Interfaces\Professional;

interface ProfilProfessionalInterface 
{

    public function index();

    public function store($request);

    public function create();

    public function update($request);

    public function edit($id);

}