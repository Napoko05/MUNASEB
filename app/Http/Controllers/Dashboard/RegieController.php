<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\DossierEnfant;
use App\Models\espace_adherant\DossierConjoint;

class RegieController extends Controller
{
    /* ======================================
        DASHBOARD
    ====================================== */
    public function dashboard()
    {
        $dossiers = DossierAdherant::with('adherant.visas')
            ->latest()
            ->take(5)
            ->get();

        foreach ($dossiers as $dossier) {
            $this->setVisaState($dossier->adherant, $dossier);
        }

        return view('dashboard.regie_recette.index', [
            'titre' => 'Tableau de bord',
            'dossiers' => $dossiers
        ]);
    }

    /* ======================================
        LISTE ADHERANTS
    ====================================== */
    public function adherantsNonValides()
    {
        $adherants = Adherant::with([
            'dossier',
            'visas',
            'universite',
            'filiere',
            'enfants.dossier',
            'conjoints.dossier'
        ])->get();

        $enAttente = [];
        $traitees = [];

        foreach ($adherants as $adherant) {
            $this->setVisaState($adherant);

            if ($adherant->visaDecision === 'en_attente') {
                $enAttente[] = $adherant;
            } else {
                $traitees[] = $adherant;
            }
        }

        return view('dashboard.regie_recette.adherants_non_valides', compact('enAttente', 'traitees'));
    }

    /* ======================================
        DETAIL ADHERANT
    ====================================== */
    public function detailAdherant($id)
    {
        $dossier = DossierAdherant::with([
            'adherant',
            'adherant.universite',
            'adherant.filiere',
            'adherant.enfants.dossier',
            'adherant.conjoints.dossier',
            'adherant.visas'
        ])->where('adherant_id', $id)->firstOrFail();

        $this->setVisaState($dossier->adherant, $dossier);

        return view('dashboard.regie_recette.adherant_detail', compact('dossier'));
    }

    /* ======================================
        ACTION ADHERANT
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
        ACTION ENFANT
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
        ACTION CONJOINT
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
        MÉTHODE GÉNÉRIQUE (🔥 COEUR DU SYSTEM)
    ====================================== */
    private function traiter($dossier, $action, $request = null)
    {
        $visa = $this->getVisa($dossier);

        if (!$visa || $visa->decision !== 'en_attente') {
            return back()->with('error', 'Action impossible : déjà traité.');
        }

        if ($action === 'rejete') {
            $request->validate([
                'motif_rejet' => 'required|string|min:5|max:500'
            ]);
        }

        $dossier->statut = $action;

        if ($action === 'valide') {
            $dossier->regie_valide = true; // ✅ ajout workflow
        }

        if ($action === 'rejete') {
            $dossier->motif_rejet = $request->motif_rejet;
        }

        $dossier->save();

        $visa->decision = $action;

        if ($action === 'rejete') {
            $visa->motif_rejet = $request->motif_rejet;
        }

        $visa->user_id = Auth::id();
        $visa->save();

        return back()->with(
            'success',
            $action === 'valide'
                ? 'Dossier validé avec succès.'
                : 'Dossier rejeté avec succès.'
        );
    }
    //Adhrent traiter
    public function adherantsTraitees()
    {
        $adherants = Adherant::with([
            'dossier',
            'visas'
        ])->get();

        $traitees = $adherants->filter(function ($adherant) {

            $visa = $adherant->visas
                ->where('etape', 'regie_recette')
                ->first();

            // Sécurité si null
            $adherant->visaDecision = $visa->decision ?? 'en_attente';

            // Peut modifier seulement si déjà traité
            $adherant->canModify = $visa && $visa->decision !== 'en_attente';

            // On ne prend que les traités
            return $adherant->visaDecision !== 'en_attente';
        });

        return view('dashboard.regie_recette.adherants_traites', compact('traitees'));
    }

    /* ======================================
        HELPERS
    ====================================== */

    private function getVisa($dossier)
    {
        if (isset($dossier->adherant)) {
            return $dossier->adherant->visas->where('etape', 'regie_recette')->first();
        }

        if (isset($dossier->addEnfant)) {
            return $dossier->addEnfant->parent->visas->where('etape', 'regie_recette')->first();
        }

        if (isset($dossier->addConjoint)) {
            return $dossier->addConjoint->parent->visas->where('etape', 'regie_recette')->first();
        }

        return null;
    }

    private function setVisaState($adherant, $dossier = null)
    {
        $visa = $adherant->visas->where('etape', 'regie_recette')->first();

        $decision = $visa->decision ?? 'en_attente';

        if ($dossier) {
            $dossier->canAct = $decision === 'en_attente';
        }

        $adherant->canAct = $decision === 'en_attente';
        $adherant->visaDecision = $decision;
    }
}
