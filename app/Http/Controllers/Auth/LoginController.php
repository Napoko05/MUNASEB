<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; //

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirige les utilisateurs après login selon leur rôle
     */
    protected function authenticated($request, $user)
{
    if ($user->hasRole('directeur')) {
        return redirect('/dashboard/directeur');
    } elseif ($user->hasRole('regie_recette')) {
   return redirect()->route('regie.dashboard');
    } elseif ($user->hasRole('liquidation_production')) {
        return redirect('/dashboard/liquidation');
    } elseif ($user->hasRole('tresorier')) {
        return redirect('/dashboard/tresorier');
    } elseif ($user->hasRole('etudiant')) {
        return redirect('/dashboard/etudiant');
    }

    return redirect('/home');
}

}
