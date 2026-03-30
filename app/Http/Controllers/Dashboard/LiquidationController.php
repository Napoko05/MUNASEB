<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\espace_adherant\Adherant;
use App\Models\Dashboard\Regie\Profil;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\Carte;
use App\Models\espace_adherant\Universite;
use App\Models\espace_adherant\Filiere;

use Barryvdh\DomPDF\Facade\Pdf;

class LiquidationController extends Controller
{
    /**
     * Dossiers validés par la régie
     */
    public function index()
    {
        $dossiers = DossierAdherant::with('adherant')
            ->where('regie_valide', true)
            ->where('liquidation_valide', false)
            ->get();

        return view('dashboard.liquidation.index', [
            'titre' => 'Dossiers validés par la régie',
            'dossiers' => $dossiers
        ]);
    }

    /**
     * CREATION CARTE + VALIDATION LIQUIDATION
     */
    public function creerCarte($id)
    {
        $dossier = DossierAdherant::with([
            'adherant.carte',
            'adherant.universite',
            'adherant.filiere'
        ])->findOrFail($id);

        // rejet global
        if ($dossier->statut === 'rejete') {
            return back()->with('error', 'Dossier rejeté.');
        }

        // validation régie obligatoire
        if (!$dossier->regie_valide) {
            return back()->with('error', 'Dossier non validé par la régie.');
        }

        // déjà traité liquidation
        if ($dossier->liquidation_valide) {
            return back()->with('error', 'Carte déjà créée.');
        }

        // génération numéro carte
        $annee = date('y');

        do {
            $numero_carte = "A-{$annee}-" . rand(1000, 9999);
        } while (Carte::where('numero_carte', $numero_carte)->exists());

        // création carte
        $carte = Carte::create([
            'adherant_id' => $dossier->adherant_id,
            'numero_carte' => $numero_carte,
            'statut' => 'cree',
            'date_effet' => now(),
            'date_creation' => now(),
            'date_validite' => now()->addYear(),
            'signature_directeur' => null,
            'qr_code_path' => null,
        ]);

        // update dossier workflow
        $dossier->update([
            'liquidation_valide' => true,
            'liquidation_visa' => auth()->user()->name,
            'statut' => 'valide'
        ]);

        $dossier->load('adherant.carte');

        $pdf = Pdf::loadView('cartes.carte_adhesion', compact('dossier'));

        return $pdf->stream('carte_' . $numero_carte . '.pdf');
    }

    /**
     * REJET GLOBAL
     */
    public function rejeter(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500',
        ]);

        $dossier = DossierAdherant::findOrFail($id);

        $dossier->update([
            'statut' => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'liquidation_valide' => false,
        ]);

        return back()->with('success', 'Dossier rejeté avec succès.');
    }

    /**
     * DETAIL PROFIL
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
     * Adhésions traitées
     */
    public function adhesionsTraitees()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', function ($q) {
                $q->where('regie_valide', true);
            })
            ->get();

        return view('dashboard.liquidation.index', [
            'adherants' => $adherants,
            'titre' => 'Adhésions validées'
        ]);
    }

    /**
     * dossiers sans carte
     */
    public function cartesNonTraite()
    {
        $dossiers = DossierAdherant::with('adherant')
            ->where('regie_valide', true)
            ->where('liquidation_valide', false)
            ->get();

        return view('dashboard.liquidation.cartes_valider', compact('dossiers'))
            ->with('titre', 'Adhérents validés sans carte');
    }

    /**
     * liste cartes
     */
    public function listeCartes()
    {
        $cartes = Carte::with('adherant')->get();

        return view('dashboard.liquidation.listecarte', compact('cartes'));
    }

    /**
     * rejet par adhérent
     */
    public function rejeterAdherant(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|min:5'
        ]);

        $dossier = DossierAdherant::where('adherant_id', $id)->firstOrFail();

        $dossier->update([
            'statut' => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'liquidation_valide' => false,
        ]);

        return redirect()->route('liquidation.cartes.liste')
            ->with('success', 'Dossier rejeté.');
    }

    /**
     * voir carte PDF
     */
    public function voirCarte($id)
    {
        $adherant = Adherant::with(['carte', 'universite', 'filiere'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('dashboard.liquidation.carte_adhesion', compact('adherant'));

        return $pdf->stream('carte_' . $adherant->nom . '.pdf');
    }

    /**
     * STATS
     */
    public function stats()
    {
        $total = DossierAdherant::count();

        $valide = DossierAdherant::where('liquidation_valide', true)->count();

        $rejete = DossierAdherant::where('statut', 'rejete')->count();

        $enAttente = DossierAdherant::where('regie_valide', true)
            ->where('liquidation_valide', false)
            ->count();

        return view('dashboard.liquidation.stats', compact(
            'total',
            'valide',
            'rejete',
            'enAttente'
        ));
    }

    /**
     * voir documents
     */
    public function voirDocument($id)
    {
        $dossier = DossierAdherant::findOrFail($id);

        return view('dashboard.liquidation.adherant_detail', compact('dossier'));
    }

    /**
     * edit carte
     */
    public function editCarte($id)
    {
        $dossier = DossierAdherant::with('adherant.carte')->findOrFail($id);

        $universites = Universite::all();
        $filieres = Filiere::all();

        return view('dashboard.liquidation.edit', compact('dossier', 'universites', 'filieres'));
    }

    /**
     * update carte
     */
    public function updateCarte(Request $request, $adherantId)
    {
        $adherant = Adherant::findOrFail($adherantId);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'tel1' => 'nullable|string|max:20',
            'numero_carte' => 'nullable|string|max:50',
            'date_effet' => 'nullable|date',
            'date_validite' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'universite_id' => 'nullable|exists:universites,id',
            'filiere_id' => 'nullable|exists:filieres,id',
        ]);

        $adherant->update($validated);

        if ($adherant->carte) {
            $adherant->carte->update([
                'numero_carte' => $request->numero_carte,
                'date_effet' => $request->date_effet,
                'date_validite' => $request->date_validite,
            ]);
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $adherant->update(['photo' => $path]);
        }

        return redirect()->back()
            ->with('success', 'Adhérent mis à jour.');
    }
}