<?php

namespace App\Interfaces\Annonce;

interface AnnonceManagementInterface
{

    public function index();

    public function store($request);

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request);

    public function post($id);

    public function getpsannonces($request);

    public function getpsmissions();

    public function show_missions($id);

    public function show_all_missions();

    public function getmissions();

    public function update_mission($id);

    public function show_history_and_future_mission();

    public function get_future_mission();

    public function get_history_mission();





}
