<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\espace_adherant\Adherant;
use Illuminate\Support\Facades\Log;


class AdhesionController extends Controller
{
    // Page pour créer une nouvelle adhésion
    public function new_adhesion()
    {
        return view('munaseb.adherent.adhesion_new');
    }

    // Page pour renouveler une adhésion
    public function renouvellement()
    {
        return view('dashboard.etudiant.renouvellement');
    }
    //page de remboursement
    public function remboursement()
    {
        return view('dashboard.etudiant.remboursement');
    }

    // Affiche le formulaire d'édition
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.etudiant.edit', compact('user'));
    }

    // Met à jour le profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('dashboard.etudiant')->with('success', 'Profil mis à jour !');
    }


    // Affiche la liste des bons de l'étudiant connecté
    public function mesbons()
    {
        $user = Auth::user();

        // Si tu as un modèle "Bon" (par exemple App\Models\Bon)
        // tu pourrais récupérer les bons ainsi :
        // $bons = Bon::where('user_id', $user->id)->get();

        // Pour l’instant, on fait simple
        $bons = []; // tu remplaceras plus tard par une vraie requête

        return view('dashboard.etudiant.mesbons.index', compact('user', 'bons'));
    }
    // Affiche l'historique des cotisations et remboursements
    public function historique()
    {
        $user = Auth::user();

        // Ces deux variables viendront plus tard de la base de données
        // Exemple : Paiement::where('user_id', $user->id)->get();
        $cotisations = [
            ['date' => '2025-02-15', 'montant' => 10000, 'statut' => 'Payé'],
            ['date' => '2024-12-20', 'montant' => 8000, 'statut' => 'Payé'],
        ];

        $remboursements = [
            ['date' => '2025-03-10', 'montant' => 5000, 'statut' => 'Effectué'],
        ];

        return view('dashboard.etudiant.historique.index', compact('user', 'cotisations', 'remboursements'));
    }

    // Page de liste des adhérants
    public function index()
    {
        // Redirection vers le dashboard étudiant
        return redirect()->route('dashboard.etudiant.index');
    }


    // Page de création
    public function create()
    {
        return view('adherant.form_adherant');
    }

    // Enregistrer un nouvel adhérant
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'ine' => 'required|unique:adherant,ine',
            'tel1' => 'required',
            'email' => 'nullable|email',
        ]);

        // Sauvegarde de la photo (optionnelle)
        $photoPath = null;
        if ($request->hasFile('avatar')) {
            $photoPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Validation
        $request->validate([
            'type_adherant' => 'required|in:etudiant,ayant_droit',
            // autres validations...
        ]);

        // Déduction du profil_id
        $profilId = match ($request->type_adherant) {
            'etudiant' => 1,
            'ayant_droit' => 2,
        };
        // Création de l’adhérant
        Adherant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'ine' => $request->ine,
            'sexe' => $request->sexe,
            'dateNaiss' => $request->dateNaiss,
            'lieuNaiss' => $request->lieuNaiss,
            'typedoc' => $request->typedoc,
            'numdoc' => $request->numdoc,
            'tel1' => $request->tel1,
            'tel2' => $request->tel2,
            'email' => $request->email,
            'idUniversite' => $request->idUniversite,
            'idFiliere' => $request->idFiliere,
            'photo' => $photoPath,
            'profil_id' => $profilId, // ✅ affecté automatiquement
        ]);
        Log::info('Adhérant enregistré');

        return redirect()->route('adherant.index')->with('success', 'Adhérant ajouté avec succès !');
    }

    // Affichage des détails
    public function show($id)
    {
        $adherant = Adherant::findOrFail($id);
        return view('adherant.show', compact('adherant'));
    }


    //Step1 enfant
    
    
}
