<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\AddEnfant;
use App\Models\espace_adherant\AddConjoint;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\DossierEnfant;
use App\Models\espace_adherant\DossierConjoint;
use App\Http\Controllers\Controller;

class RegieController extends Controller
{
    // Dashboard principal
    public function dashboard()
    {
        $dossiers = DossierAdherant::with('adherant')
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.regie_recette.index', [
            'titre' => 'Tableau de bord',
            'dossiers' => $dossiers
        ]);
    }

    /* =========================
       ADHERANTS
    ========================= */
    public function adherantsNonValides()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', fn($q) => $q->where('statut', 'en_attente'))
            ->get();

        return view('dashboard.regie_recette.adherants_non_valides', compact('adherants'));
    }

    public function detailAdherant($id)
    {
        $adherant = Adherant::with(['dossier', 'enfants.dossier', 'conjoints.dossier'])
            ->findOrFail($id);

        return view('dashboard.regie_recette.adherant_detail', compact('adherant'));
    }

    public function validerAdherant($id)
    {
        $dossier = DossierAdherant::where('adherant_id', $id)->firstOrFail();
        $dossier->statut = 'valide';
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier adhérent validé.');
    }

    public function rejeterAdherant(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|min:5'
        ]);

        $dossier = DossierAdherant::where('adherant_id', $id)->firstOrFail();
        $dossier->statut = 'rejete';
        $dossier->motif_rejet = $request->motif_rejet;
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier adhérent rejeté avec motif.');
    }

    /* =========================
       ENFANTS
    ========================= */
    public function enfantsNonValides()
    {
        $enfants = AddEnfant::with('dossier', 'parent')
            ->whereHas('dossier', fn($q) => $q->where('statut', 'en_attente'))
            ->get();

        return view('dashboard.regie_recette.enfants_non_valides', compact('enfants'));
    }

    public function detailEnfant($id)
    {
        $enfant = AddEnfant::with('dossier', 'parent')->findOrFail($id);
        return view('dashboard.regie_recette.enfant_detail', compact('enfant'));
    }

    public function validerEnfant($id)
    {
        $dossier = DossierEnfant::where('add_enfant_id', $id)->firstOrFail();
        $dossier->statut = 'valide';
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier enfant validé.');
    }

    public function rejeterEnfant(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|min:5'
        ]);

        $dossier = DossierEnfant::where('add_enfant_id', $id)->firstOrFail();
        $dossier->statut = 'rejete';
        $dossier->motif_rejet = $request->motif_rejet;
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier enfant rejeté.');
    }

    /* =========================
       CONJOINTS
    ========================= */
    public function conjointsNonValides()
    {
        $conjoints = AddConjoint::with('dossier', 'parent')
            ->whereHas('dossier', fn($q) => $q->where('statut', 'en_attente'))
            ->get();

        return view('dashboard.regie_recette.conjoints_non_valides', compact('conjoints'));
    }

    public function detailConjoint($id)
    {
        $conjoint = AddConjoint::with('dossier', 'parent')->findOrFail($id);
        return view('dashboard.regie_recette.conjoint_detail', compact('conjoint'));
    }

    public function validerConjoint($id)
    {
        $dossier = DossierConjoint::where('add_conjoint_id', $id)->firstOrFail();
        $dossier->statut = 'valide';
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier conjoint validé.');
    }

    public function rejeterConjoint(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'required|min:5'
        ]);

        $dossier = DossierConjoint::where('add_conjoint_id', $id)->firstOrFail();
        $dossier->statut = 'rejete';
        $dossier->motif_rejet = $request->motif_rejet;
        $dossier->save();

        return redirect()->back()->with('success', 'Dossier conjoint rejeté.');
    }

    /* =========================
       ADHERENTS TRAITES
    ========================= */
    public function adhesionsTraitees()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', fn($q) => $q->whereIn('statut', ['valide', 'rejete']))
            ->get();

        return view('dashboard.regie_recette.adherants_traiter', compact('adherants'));
    }

    /* Modifier un adhérent traité */
    public function modifierAdherant($id)
    {
        $adherant = Adherant::with('dossier')->findOrFail($id);
        return view('dashboard.regie_recette.adherant_modifier', compact('adherant'));
    }
}
