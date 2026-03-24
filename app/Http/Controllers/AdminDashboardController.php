<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protéger la page
    }

    public function index()
    {
        return view('admin.dashboard'); // renvoie la vue créée ci-dessus
    }
}
