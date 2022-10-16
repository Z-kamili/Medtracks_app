<?php

namespace App\Interfaces\Annonce\Establishment;

interface EsAnnonceManagementInterface
{

    public function index();

    public function store($request);

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request,$id);

    public function destroy($id);

    public function getesannonces($request);

    public function getesmission_enattent($request);

    public function get_es_my_annonces($request);

    public function getesmission_accepte($request);

    public function get_es_mission_valide();

    public function get_all_es_mission_valide();

    public function show_all_mission();

    public function get_es_all_mission_valide();

    public function show_announcements_history();

    public function all_announcements_history();

}
