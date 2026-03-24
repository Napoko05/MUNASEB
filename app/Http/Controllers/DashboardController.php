<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Middleware pour protéger la route
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Méthode pour afficher le dashboard principal
    public function index()
    {
        // La vue inclura le layout avec le sidebar
        return view('dashboard.etudiant.index'); 
    }
}
