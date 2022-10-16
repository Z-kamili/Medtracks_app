<?php
namespace App\Interfaces\Admin;

interface AdminRepositoryInterface 
{

    public function index();

    public function store($request);

    public function create();

    public function update($request);

    
}