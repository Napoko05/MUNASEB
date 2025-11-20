<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dashboard\Regie\Adhesion;
use App\Models\Dashboard\Regie\Reabonnement;
use App\Models\Dashboard\Regie\Profil;
use App\Models\Dashboard\Regie\Dossier;

class DirecteurController extends Controller
{
    /**
     * Nouvelle adhésion en cours
     */
    public function index()
{
    // 🔒 Appel désactivé temporairement (cause d'erreur SQL)
    // $dossiers = Dossier::with('profil')
    //     ->where('statut', 'en_attente')
    //     ->get();

    // ✅ Données fictives pour tester ton tableau de bord
    $dossiers = [
        (object)[
            'id' => 1,
            'statut' => 'en_attente',
            'profil' => (object)[
                'nom' => 'Ouédraogo',
                'prenom' => 'Lamine'
            ]
        ],
        (object)[
            'id' => 2,
            'statut' => 'en_attente',
            'profil' => (object)[
                'nom' => 'Zongo',
                'prenom' => 'Aminata'
            ]
        ],
    ];

    return view('dashboard.directeur.index', [
        'titre' => 'Adhésions non traitées',
        'dossiers' => $dossiers
    ]);
}


    /**
     * Réabonnement en cours
     */
    public function reabonnementEnCours()
    {
        $dossiers = Reabonnement::where('statut', 'en_attente')
            ->with('profil.user')
            ->get();
        $titre = "Réabonnements en cours";
        return view('dashboard.directeur.index', compact('dossiers', 'titre'));
    }

    /**
     * Afficher les détails du profil
     */
    public function detailProfil($profilId)
    {
        $profil = Profil::with('user', 'adhesions', 'reabonnements')->findOrFail($profilId);
        return view('dashboard.directeur.detail_profil', compact('profil'));
    }

    /**
     * Afficher les détails de l'adhésion ou du réabonnement
     */
    public function detailAdhesion($dossierId)
    {
        $dossier = Adhesion::with('profil')->find($dossierId);

        if (!$dossier) {
            $dossier = Reabonnement::with('profil')->findOrFail($dossierId);
        }

        return view('dashboard.direcreur.detail_adhesion', compact('dossier'));
    }

    /**
     * Traiter un dossier (valider / rejeter)
     */
    public function traiter(Request $request, $dossierId)
    {
        $request->validate([
            'statut' => 'required|in:valide,rejete',
            'commentaire' => 'nullable|string|max:500'
        ]);

        $dossier = Adhesion::find($dossierId);

        if (!$dossier) {
            $dossier = Reabonnement::findOrFail($dossierId);
        }

        $dossier->statut = $request->statut;
        $dossier->commentaire = $request->commentaire;
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier traité avec succès.');
    }

    /**
     * Liste des adhésions traitées
     */
    public function adhesionsTraiter()
    {
        $dossiers = Adhesion::whereIn('statut', ['valide', 'rejete'])
            ->with('profil.user')
            ->get();
        $titre = "Adhésions traitées";
        return view('dashboard.directeur.index', compact('dossiers', 'titre'));
    }

    /**
     * Liste des cartes générées
     */
    public function cartes()
    {
        $cartes = Adhesion::where('statut', 'valide')->with('profil.user')->get();
        $titre = "Cartes des adhérents";
        return view('dashboard.directeur.cartes', compact('cartes', 'titre'));
    }

    /**
     * Statistiques
     */
    public function stats()
    {
        $total = Adhesion::count();
        $valide = Adhesion::where('statut', 'valide')->count();
        $rejete = Adhesion::where('statut', 'rejete')->count();
        $enAttente = Adhesion::where('statut', 'en_attente')->count();

        $pourcentageValide = $total ? round(($valide / $total) * 100, 2) : 0;
        $pourcentageRejete = $total ? round(($rejete / $total) * 100, 2) : 0;

        return view('dashboard.directeur.stats', compact(
            'total',
            'valide',
            'rejete',
            'enAttente',
            'pourcentageValide',
            'pourcentageRejete'
        ));
    }
}
