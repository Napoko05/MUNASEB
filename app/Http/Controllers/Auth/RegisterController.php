<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validation des données d'inscription
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'ine'      => ['required', 'string', 'max:255', 'unique:users,ine'],
            'nom'      => ['required', 'string', 'max:255'],
            'prenom'   => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',               // minimum 8 caractères
                'confirmed',           // doit correspondre à password_confirmation
                'regex:/[a-z]/',       // au moins une minuscule
                'regex:/[A-Z]/',       // au moins une majuscule
                'regex:/[0-9]/',       // au moins un chiffre
                'regex:/[@$!%*#?&]/'   // au moins un caractère spécial
            ],
        ], [
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'password.min'   => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);
    }

    /**
     * Création de l'utilisateur
     */
    protected function create(array $data)
    {
        // Création du compte étudiant
        $user = User::create([
            'ine'      => $data['ine'],
            'nom'      => $data['nom'],
            'prenom'   => $data['prenom'],
            'email'    => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
            'statut_compte' => 'preinscrit',
        ]);

        // Assigner le rôle étudiant (doit exister via le seeder)
        $user->assignRole('etudiant');

        return $user;
    }

    /**
     * Après l'inscription, déconnexion automatique
     */
    protected function registered($request, $user)
    {
        auth()->logout();

        return redirect()->route('home')
            ->with('success', 'Compte créé avec succès. Veuillez vous connecter avec votre INE.');
    }
}