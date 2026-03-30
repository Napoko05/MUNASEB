<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\Carte;

use Barryvdh\DomPDF\Facade\Pdf;

class DirecteurController extends Controller
{
    /* ======================================
        DASHBOARD CARTES À SIGNER
    ====================================== */
    public function index()
    {
        $cartes = Carte::with('adherant')
            ->where('statut', 'cree')
            ->get();

        return view('dashboard.directeur.index', [
            'cartes' => $cartes,
            'titre' => 'Cartes à signer'
        ]);
    }

    /* ======================================
        SIGNATURE CARTE
    ====================================== */
    public function signerCarte($id)
    {
        $carte = Carte::findOrFail($id);

        $agent = auth()->user()->agent;

        if (!$agent || !$agent->signature_file) {
            return back()->with('error', 'Signature électronique introuvable');
        }

        $carte->update([
            'signature_directeur' => $agent->signature_file,
            'directeur_visa' => auth()->user()->nom ?? null,
            'statut' => 'signe',
        ]);

        return back()->with('success', 'Carte signée avec succès');
    }
    /* ======================================
        TÉLÉCHARGER CARTE
    ====================================== */
    public function telechargerCarte($id)
    {
        $carte = Carte::with('adherant')->findOrFail($id);

        if ($carte->statut !== 'signe') {
            return back()->with('error', 'Carte non signée.');
        }

        $pdf = Pdf::loadView('dashboard.directeur.carte_pdf', compact('carte'));

        return $pdf->download('carte_' . $carte->numero_carte . '.pdf');
    }

    /* ======================================
        LISTE CARTES SIGNÉES
    ====================================== */
    public function listeCartes()
    {
        $cartes = Carte::with('adherant')
            ->where('statut', 'signe')
            ->get();

        return view('dashboard.directeur.cartes_liste', compact('cartes'));
    }

    /* ======================================
        MÉTHODE GÉNÉRIQUE (OPTIONNEL)
    Directeur ne doit PAS rejuger dossier
    ====================================== */

    private function traiter($dossier, $action, $request = null)
    {
        // 🔒 sécurité workflow
        if (!$dossier->liquidation_valide) {
            return back()->with('error', 'La liquidation doit valider avant.');
        }

        if ($action === 'rejete') {
            $request->validate([
                'motif_rejet' => 'required|string|min:5|max:500'
            ]);
        }

        $dossier->statut = $action;

        if ($action === 'valide') {
            $dossier->directeur_valide = true;
        }

        if ($action === 'rejete') {
            $dossier->motif_rejet = $request->motif_rejet;
        }

        $dossier->save();

        return back()->with(
            'success',
            $action === 'valide'
                ? 'Dossier validé par le directeur.'
                : 'Dossier rejeté par le directeur.'
        );
    }

    /* ======================================
        DETAILS DOSSIER
    ====================================== */
    public function voirDocument($id)
    {
        $dossier = DossierAdherant::with('adherant')
            ->findOrFail($id);

        return view('dashboard.directeur.adherant_detail', compact('dossier'));
    }

    /* ======================================
        VOIR CARTE PDF
    ====================================== */
    public function voirCarte($id)
    {
        $adherant = Adherant::with('carte')
            ->findOrFail($id);

        $pdf = Pdf::loadView('dashboard.directeur.carte_adhesion', compact('adherant'));

        return $pdf->stream('carte_' . $adherant->nom . '.pdf');
    }
}
