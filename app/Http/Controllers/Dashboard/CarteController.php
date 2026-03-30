<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\espace_adherant\Carte;
use App\Models\espace_adherant\Adherant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\espace_adherant\DossierAdherant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CarteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // seul directeur crée
        $this->middleware('role:directeur|admin')
            ->only(['creer', 'signer']);

        // consultation
        $this->middleware('role:liquidation_production|directeur|etudiant|admin')
            ->only(['listeCartes', 'telecharger', 'cartesEnAttente']);
    }

    /**
     * CRÉER CARTE (DIRECTEUR)
     */
    public function creer(Adherant $adherant)
    {
        $dossier = $adherant->dossier;

        //  doit être validé par liquidation
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
     *  LISTE POUR DIRECTEUR
     
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
     */
    /**
     * 🔥 SIGNATURE DIRECTEUR = VALIDATION FINALE
     */
    public function signer($id)
    {

        $carte = Carte::with('adherant.dossier')->findOrFail($id);

        if ($carte->signature_directeur) {
            return back()->with('info', 'Carte déjà signée.');
        }

        $user = auth()->user();

        if (!$user->signature_path) {
            return back()->with('error', 'Aucune signature électronique trouvée.');
        }

        $carte->update([
            'signature_directeur' => $user->signature_path,
        ]);

        // validation dossier
        $dossier = $carte->adherant->dossier;
        $dossier->statut = 'valide';
        $dossier->save();

        return back()->with('success', 'Carte signée avec succès.');
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
        $dossier = DossierAdherant::with([
            'adherant.carte',
            'adherant.universite',
            'adherant.filiere'
        ])->where('adherant_id', $id)->firstOrFail();

        // 🔐 sécurité
        if ($dossier->statut !== 'valide') {
            return back()->with('error', 'Carte non encore validée.');
        }

        $pdf = \PDF::loadView('cartes.carte_adhesion', compact('dossier'));

        return $pdf->download('carte_' . $dossier->adherant->id . '.pdf');
    }
    public function verification($numero)
    {
        $carte = Carte::with('adherant.dossier')
            ->where('numero_carte', $numero)
            ->first();

        if (!$carte) {
            abort(404, 'Carte introuvable');
        }

        return view('cartes.verification', compact('carte'));
    }
}
