<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\DossierEnfant;
use App\Models\espace_adherant\DossierConjoint;

use App\Models\espace_adherant\Carte;

use Barryvdh\DomPDF\Facade\Pdf;

class DirecteurController extends Controller
{
    /* ======================================
        DASHBOARD (cartes à signer)
    ====================================== */
    public function index()
    {
        $cartes = Carte::with('adherant')
            ->where('statut', 'cree') // 🔥 seulement cartes liquidation
            ->get();

        return view('dashboard.directeur.index', [
            'carte' => $cartes,
            'titre' => 'Cartes à signer'
        ]);
    }

    /* ======================================
        SIGNATURE CARTE
    ====================================== */
    public function signerCarte($id)
    {
        $carte = Carte::findOrFail($id);

        // 🔒 sécurité workflow
        if ($carte->statut !== 'cree') {
            return back()->with('error', 'Carte non prête.');
        }

        if ($carte->directeur_valide) {
            return back()->with('error', 'Carte déjà signée.');
        }

        $carte->directeur_valide = true;
        $carte->directeur_visa   = Auth::user()->name;
        $carte->statut = 'signe';
        $carte->save();

        return back()->with('success', 'Carte signée avec succès.');
    }

    /* ======================================
        TELECHARGER CARTE
    ====================================== */
    public function telechargerCarte($id)
    {
        $carte = Carte::with('adherant')->findOrFail($id);

        if (!$carte->directeur_valide) {
            return back()->with('error', 'Carte non signée.');
        }

        $pdf = Pdf::loadView('dashboard.directeur.carte_pdf', compact('carte'));

        return $pdf->download('carte_' . $carte->numero . '.pdf');
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
        VALIDATION ADHERANT (optionnel)
    ====================================== */
    public function validerAdherant($id)
    {
        return $this->traiter(
            DossierAdherant::where('adherant_id', $id)->firstOrFail(),
            'valide'
        );
    }

    public function rejeterAdherant(Request $request, $id)
    {
        return $this->traiter(
            DossierAdherant::where('adherant_id', $id)->firstOrFail(),
            'rejete',
            $request
        );
    }

    /* ======================================
        VALIDATION ENFANT
    ====================================== */
    public function validerEnfant($id)
    {
        return $this->traiter(
            DossierEnfant::where('add_enfant_id', $id)->firstOrFail(),
            'valide'
        );
    }

    public function rejeterEnfant(Request $request, $id)
    {
        return $this->traiter(
            DossierEnfant::where('add_enfant_id', $id)->firstOrFail(),
            'rejete',
            $request
        );
    }

    /* ======================================
        VALIDATION CONJOINT
    ====================================== */
    public function validerConjoint($id)
    {
        return $this->traiter(
            DossierConjoint::where('add_conjoint_id', $id)->firstOrFail(),
            'valide'
        );
    }

    public function rejeterConjoint(Request $request, $id)
    {
        return $this->traiter(
            DossierConjoint::where('add_conjoint_id', $id)->firstOrFail(),
            'rejete',
            $request
        );
    }

    /* ======================================
        MÉTHODE GÉNÉRIQUE (workflow)
    ====================================== */
    private function traiter($dossier, $action, $request = null)
    {
        // 🔒 sécurité : liquidation doit avoir validé
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
                ? 'Validé par le directeur.'
                : 'Rejeté par le directeur.'
        );
    }

    /* ======================================
        DETAIL DOSSIER
    ====================================== */
    public function voirDocument($id)
    {
        $dossier = DossierAdherant::findOrFail($id);
        return view('dashboard.directeur.adherant_detail', compact('dossier'));
    }

    /* ======================================
        VOIR CARTE (PDF)
    ====================================== */
    public function voirCarte($id)
    {
        $adherant = Adherant::with('carte')->findOrFail($id);

        $pdf = Pdf::loadView('dashboard.directeur.carte_adhesion', compact('adherant'));

        return $pdf->stream('carte_' . $adherant->nom . '.pdf');
    }
}
