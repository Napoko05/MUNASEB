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

class LiquidationController extends Controller
{
    /**
     * Tableau de bord : dossiers validés par la régie
     */
    public function index()
    {
        $dossiers = DossierAdherant::with('adherant')
            ->where('statut', 'valide')
            ->get();

        return view('dashboard.liquidation.index', [
            'titre'    => 'Dossiers validés par la régie',
            'dossiers' => $dossiers
        ]);
    }
    //Validation des information de la carte
    public function creerCarte($id)
    {
        // 🔍 Récupération du dossier
        $dossier = DossierAdherant::findOrFail($id);

        // 🔒 Sécurité : validation régie obligatoire
        if (!$dossier->regie_valide) {
            return back()->with('error', 'Le dossier doit être validé par la régie.');
        }

        // 🔒 Empêcher double création
        if ($dossier->liquidation_valide) {
            return back()->with('error', 'Carte déjà créée.');
        }

        // 🔢 Génération numéro carte unique
        $annee = date('y'); // ex: 26
        do {
            $aleatoire = rand(1000, 9999);
            $numero_carte = "A-{$annee}-{$aleatoire}";
        } while (Carte::where('numero_carte', $numero_carte)->exists());

        // 📅 Dates
        $date_effet = now();
        $date_validite = now()->addYear();

        // ✅ Création carte
        $carte = Carte::create([
            'adherant_id'  => $dossier->adherant_id,
            'numero_carte' => $numero_carte,
            'statut'       => 'cree',
            'date_effet'   => $date_effet,
            'date_creation' => $date_effet,
            'date_validite' => $date_validite,
            'signature_directeur' => null,
            'qr_code_path' => null,
        ]);

        // ✅ Mise à jour dossier
        $dossier->liquidation_valide = true;
        $dossier->liquidation_visa = auth()->user()->name;
        $dossier->save();

        // 📥 Charger adhérant + relations
        $adherant = Adherant::with([
            'carte',
            'universite',
            'filiere'
        ])->findOrFail($dossier->adherant_id);

        // 🧾 Générer PDF (RECTO/VERSO)
        $pdf = Pdf::loadView('dashboard.liquidation.carte_adhesion', compact('adherant'));

        // 👉 Affichage direct
        return $pdf->stream('carte_' . $numero_carte . '.pdf');

        // 👉 OU téléchargement
        // return $pdf->download('carte_'.$numero_carte.'.pdf');
    }
    public function rejeter(Request $request, $id)
    {
        if (!$request->isMethod('post')) {
            return back()->with('error', 'Méthode non autorisée.');
        }

        $request->validate([
            'motif_rejet' => 'required|string|max:500',
        ]);

        $dossier = DossierAdherant::findOrFail($id);
        $dossier->statut = 'rejete';
        $dossier->motif_rejet = $request->motif_rejet;
        $dossier->save();

        return back()->with('success', 'Rejet effectué avec succès.');
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

        return view('dashboard.liquidation.profil', compact('profil'));
    }

    /**
     * Liste des adhésions validées (traitées par la régie)
     */
    public function adhesionsTraitees()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', fn($q) => $q->where('statut', 'valide'))
            ->get();

        return view('dashboard.liquidation.index', [
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
            ->whereDoesntHave('adherant.carte') // exclut ceux qui ont déjà une carte
            ->get();

        return view('dashboard.liquidation.cartes_valider', compact('dossiers', 'adherent'))
            ->with('titre', 'Adhérents validés sans carte');
    }
    /**
     * Liste des cartes déjà créées
     */
    public function listeCartes()
    {
        $cartes = Carte::with('adherant')->get();
        return view('dashboard.liquidation.listecarte', compact('cartes'));
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
        return redirect()->route('liquidation.cartes.liste')
            ->with('success', 'Dossier adhérent rejeté avec motif.');
    }
    /**
     * Voir la carte d’un adhérent au format PDF
     */
    public function voirCarte($id)
    {
        $adherant = Adherant::with(['carte', 'universites', 'filieres'])->findOrFail($id);

        // Générer le PDF à partir de la vue Blade
        $pdf = Pdf::loadView('dashboard.liquidation.carte_adhesion ', compact('adherant'));

        // Afficher directement dans le navigateur
        return $pdf->stream('carte_' . $adherant->nom . '.pdf');
    }
    /**
     * Statistiques
     */
    public function stats()
    {
        $total      = DossierAdherant::count();
        $valide     = DossierAdherant::where('statut', 'valide')->count();
        $rejete     = DossierAdherant::where('statut', 'rejete')->count();
        $enAttente  = DossierAdherant::where('statut', 'en_attente')->count();

        $pourcentageValide = $total ? round(($valide / $total) * 100, 2) : 0;
        $pourcentageRejete = $total ? round(($rejete / $total) * 100, 2) : 0;

        return view('dashboard.liquidation.stats', compact(
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
        return view('dashboard.liquidation.adherant_detail', compact('dossier'));
    }
}
