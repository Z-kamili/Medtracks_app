<?php
namespace App\Interfaces\Annonce;

interface AnnonceRepositoryInterface 
{

    public function index();

    public function store($request);

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request,$id);

    public function destroy($id);

    public function valider($id);

    public function getservices($id);

    public function getmodalites($id);

    public function getmetier($id);

    public function getannonces();

    public function latestannonce();

    public function getskills($id);

    public function get_type($id);

    public function get_profession($id);

    public function latestmission();

}