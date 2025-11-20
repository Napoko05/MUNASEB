<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    public function index()
    {
         $user = Auth::user();
        return view('dashboard.etudiant.index', compact('user'));
    }
}
