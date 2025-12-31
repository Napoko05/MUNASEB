<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\espace_adherant\Adherant;
use App\Models\Dashboard\Regie\Profil;
use App\Models\Dashboard\Regie\Adhesion;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\Dashboard\Regie\Dossier;
use App\Models\espace_adherant\Carte;
 use Barryvdh\DomPDF\Facade\Pdf;

class DirecteurController extends Controller
{
    /**
     * Tableau de bord : dossiers validés par la régie
     */
    public function index()
    {
        $dossiers = DossierAdherant::with('adherant')
            ->where('statut', 'valide')
            ->get();

        return view('dashboard.directeur.index', [
            'titre'    => 'Dossiers validés par la régie',
            'dossiers' => $dossiers
        ]);
    }

    /**
     * Détail du profil d’un adhérent
     */
    public function detailProfil($id)
    {
        $profil = Profil::with([
            'adherant',
            'adhesions',
            'reabonnements'
        ])->findOrFail($id);

        return view('dashboard.directeur.profil', compact('profil'));
    }

    /**
     * Liste des adhésions validées (traitées par la régie)
     */
    public function adhesionsTraitees()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', fn($q) => $q->where('statut', 'valide'))
            ->get();

        return view('dashboard.directeur.adhesions_traitees', [
            'adherants' => $adherants,
            'titre'     => 'Adhésions validées'
        ]);
    }

    /**
     * Adhérents validés mais sans carte
     */
    public function cartesNonTraite()
    {
        $dossiers = DossierAdherant::with('adherant')
            ->where('statut', 'valide')
            ->whereDoesntHave('adherant.carte') // 🔑 exclut ceux qui ont déjà une carte
            ->get();

        return view('dashboard.directeur.cartes_valider', compact('dossiers'))
            ->with('titre', 'Adhérents validés sans carte');
    }

    /**
     * Liste des cartes déjà créées
     */
    public function listeCartes()
    {
        $cartes = Carte::with('adherant')->get();
        return view('dashboard.directeur.listecarte', compact('cartes'));
    }

    /**
     * Rejeter un adhérent avec motif
     */
    public function rejeterAdherant(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|min:5'
        ]);

        $dossier = DossierAdherant::where('adherant_id', $id)->firstOrFail();
        $dossier->statut = 'rejete';
        $dossier->motif_rejet = $request->motif_rejet;
        $dossier->save();

        // Migration automatique vers la liste des rejetés
        return redirect()->route('directeur.adhesion.traites')
            ->with('success', 'Dossier adhérent rejeté avec motif.');
    }
    /**
     * Voir la carte d’un adhérent au format PDF
     */

    public function voirCarte($id)
    {
        $adherant = Adherant::with(['carte', 'universites', 'filieres'])->findOrFail($id);

        // Générer le PDF à partir de la vue Blade
        $pdf = Pdf::loadView('dashboard.directeur.carte_adhesion ', compact('adherant'));

        // Afficher directement dans le navigateur
        return $pdf->stream('carte_' . $adherant->nom . '.pdf');
    }


    /**
     * Statistiques
     */
    public function stats()
    {
        $total      = Adhesion::count();
        $valide     = Adhesion::where('statut', 'valide')->count();
        $rejete     = Adhesion::where('statut', 'rejete')->count();
        $enAttente  = Adhesion::where('statut', 'en_attente')->count();

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

    /**
     * Voir les documents liés à un dossier
     */
    public function voirDocument($id)
    {
        $dossier = DossierAdherant::findOrFail($id);
        return view('dashboard.directeur.adherant_detail', compact('dossier'));
    }
}
