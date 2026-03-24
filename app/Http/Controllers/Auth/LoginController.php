<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Champ login du formulaire
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Tenter la connexion avec matricule (agent) ou ine (etudiant)
     */
    protected function attemptLogin(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $user = \App\Models\User::where('ine', $login)
            ->orWhere('matricule', $login)
            ->first();

        if (!$user) {
            return false;
        }

        $fieldType = $user->ine ? 'ine' : 'matricule';

        return Auth::attempt([
            $fieldType => $login,
            'password' => $password,
        ], $request->filled('remember'));
    }

    /**
     * Redirection après login selon rôle
     */
    protected function authenticated(Request $request, $user)
    {
        // Map roles => routes
        $rolesDashboard = [
            'etudiant' => 'dashboard.etudiant',
            'admin' => 'dashboard.admin',
            'regie_recette' => 'dashboard.regie',
            'liquidation_production' => 'liquidation.dashboard',
            'medecin' => 'dashboard.medecin',
            'medecin_conseil' => 'dashboard.medecin_conseil',
            'finance' => 'dashboard.finance',
            'directeur' => 'dashboard.directeur',
            'tresorier' => 'dashboard.tresorier',
        ];

        foreach ($rolesDashboard as $role => $route) {
            if ($user->hasRole($role)) {
                return redirect()->route($route);
            }
        }

        // Par défaut
        return redirect($this->redirectTo);
    }
}