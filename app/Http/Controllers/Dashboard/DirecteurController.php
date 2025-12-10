<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\espace_adherant\Adherant;
use App\Models\Dashboard\Regie\Profil;
use App\Models\Dashboard\Regie\Adhesion;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\Dashboard\Regie\Dossier;

class DirecteurController extends Controller
{
    /**
     * Dashboard directeur
     * Affiche les dossiers VALIDÉS par la régie
     */
    public function index()
    {
        $dossiers = DossierAdherant::with('adherant') // récupère adhérent lié au dossier
            ->where('statut', 'valide')
            ->get();

        return view('dashboard.directeur.index', [
            'titre'    => 'Dossiers validés par la régie',
            'dossiers' => $dossiers
        ]);
    }


    /**
     * Détail du profil
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
     * Liste des adhésions traitées
     */
    public function adhesionsTraitees()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', function ($q) {
                $q->where('statut', 'valide');
            })
            ->get();

        $titre = 'Adhésions traitées';

        return view(
            'dashboard.directeur.adhesions_traitees',
            compact('adherants', 'titre')
        );
    }

    /**
     * Cartes validées
     */
    public function cartesNonTraite()
    {
        $adherants = Adherant::with('dossier')
            ->whereHas('dossier', fn($q) => $q->where('statut', 'valide'))
            ->get();

        return view('dashboard.directeur.cartes_valider', compact('adherants'));
    }


    /**
     * Créer la carte pour un adhérent validé
     */
    public function creerCarte($id)
    {
        $adherant = Adherant::with(['universites', 'filieres', 'dossier'])
            ->whereHas('dossier', function ($q) {
                $q->where('statut', 'valide');
            })
            ->findOrFail($id);

        $agent = auth()->user();

        // Génération numéro carte
        if (empty($adherant->numeroCarte)) {
            $annee  = date('y');
            $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $adherant->numeroCarte = $random . '-' . $annee;
        }

        $adherant->date_adhesion = now();
        $adherant->date_validite = now()->addYear();
        $adherant->signature_directeur = 'signatures/directeur.png';
        $adherant->save();

        // Génération QR Code
        $qrFileName = 'qr_adherant_' . $adherant->id . '.svg';
        $qrPath     = 'qr/' . $qrFileName;

        $qrDir = storage_path('app/public/qr');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        \QrCode::format('svg')
            ->size(200)
            ->generate(
                route('regie.adherant.detail', $adherant->id),
                storage_path('app/public/' . $qrPath)
            );

        return view('dashboard.directeur.carte_adhesion', [
            'adherant' => $adherant,
            'agent'    => $agent,
            'qrPath'   => $qrPath
        ]);
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
}
