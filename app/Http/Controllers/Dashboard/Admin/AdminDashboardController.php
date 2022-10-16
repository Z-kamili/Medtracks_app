<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\AdminRepositoryInterface;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    private $Admin;

    public function __construct(AdminRepositoryInterface $admin)
    {

        $this->Admin = $admin;
        
    }
    public function create()
    {
       return $this->Admin->create();
    }

    public function index()
    {

        return $this->Admin->index();

    }
}
