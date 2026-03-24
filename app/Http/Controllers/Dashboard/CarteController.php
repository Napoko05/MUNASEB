<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\espace_adherant\Carte;
use App\Models\espace_adherant\Adherant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\espace_adherant\DossierAdherant;

class CarteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // ❌ liquidation ne crée PLUS
        // ✅ seul directeur crée
        $this->middleware('role:directeur|admin')
            ->only(['creer', 'signer']);

        // consultation
        $this->middleware('role:liquidation_production|directeur|admin')
            ->only(['listeCartes', 'telecharger', 'cartesEnAttente']);
    }

    /**
     * 🔥 CREATION PAR LE DIRECTEUR
     */
    public function creer(Adherant $adherant)
    {
        $dossier = $adherant->dossier;

        // ✅ doit être validé par liquidation
        if (!$dossier || !$dossier->liquidation_valide) {
            abort(403, 'La liquidation doit valider avant.');
        }

        // éviter doublon
        if ($adherant->carte) {
            return back()->with('info', 'Carte déjà créée.');
        }

        // numéro carte
        $numeroCarte = 'A-' . now()->format('Y') . '-' . str_pad($adherant->id, 5, '0', STR_PAD_LEFT);

        Carte::create([
            'adherant_id'   => $adherant->id,
            'numero_carte'  => $numeroCarte,
            'date_effet'    => now(),
            'date_validite' => now()->addYear(),
            'signature_directeur' => null
        ]);

        return back()->with('success', 'Carte créée. En attente de signature.');
    }

    /**
     * 🔥 LISTE POUR DIRECTEUR
     */
    public function cartesEnAttente()
    {
        // cartes à signer
        $cartes = Carte::with('adherant')
            ->whereNull('signature_directeur')
            ->get();

        // dossiers validés par liquidation MAIS sans carte
        $dossiers = DossierAdherant::with('adherant')
            ->where('liquidation_valide', true)
            ->whereDoesntHave('adherant.carte')
            ->get();

        return view('dashboard.directeur.index', compact('cartes', 'dossiers'));
    }

    /**
     * 🔥 SIGNATURE DIRECTEUR = VALIDATION FINALE
     */
    public function signer($id)
    {
        $carte = Carte::with('adherant.dossier')->findOrFail($id);

        if ($carte->signature_directeur) {
            return back()->with('info', 'Carte déjà signée.');
        }

        // signature
        $carte->update([
            'signature_directeur' => 'signatures/directeur.png',
        ]);

        // 🔥 VALIDATION FINALE
        $dossier = $carte->adherant->dossier;
        $dossier->statut = 'valide';
        $dossier->save();

        return back()->with('success', 'Carte signée et validée.');
    }

    /**
     * LISTE CARTES
     */
    public function listeCartes()
    {
        $cartes = Carte::with('adherant')->get();
        return view('dashboard.liquidation.listecarte', compact('cartes'));
    }

    /**
     * TELECHARGEMENT
     */
    public function telecharger($id)
    {
        $adherant = Adherant::with('dossier')->findOrFail($id);

        // 🔥 sécurité
        if ($adherant->dossier->statut !== 'valide') {
            return back()->with('error', 'Carte non encore validée.');
        }

        $pdf = \PDF::loadView('dashboard.liquidation.carte_adhesion', compact('adherant'));

        return $pdf->download('carte_' . $adherant->id . '.pdf');
    }
}