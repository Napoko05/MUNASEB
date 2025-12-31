<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\espace_adherant\Carte;
use App\Models\espace_adherant\Adherant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarteController extends Controller
{
    /**
     * POST : créer la carte automatiquement
     */
    public function creer(Adherant $adherant)
    {
        // Vérification : dossier doit être validé
        if (!$adherant->dossier || $adherant->dossier->statut !== 'valide') {
            abort(403, 'Adhérent non validé');
        }

        // Vérification : éviter doublon
        if ($adherant->carte) {
            return redirect()->route('directeur.cartes.listecarte')
                ->with('info', 'Carte déjà créée.');
        }

        //  Message de confirmation avant création
        session()->flash('info', 'Carte en cours de création...');

        // Numéro unique
        $numeroCarte = 'MNS-' . now()->format('Y') . '-' . str_pad($adherant->id, 5, '0', STR_PAD_LEFT);

        // Création de la carte
        Carte::create([
            'adherant_id'         => $adherant->id,
            'numero_carte'        => $numeroCarte,
            'date_effet'          => now(),
            'date_validite'       => now()->addYear(),
            'signature_directeur' => 'signatures/directeur.png',
        ]);

        // Message final de succès + migration vers liste des cartes
        return redirect()->route('directeur.cartes.listecarte')
            ->with('success', 'Carte créée avec succès.');
    }

    /**
     * GET : liste des cartes
     */
    public function listeCartes()
    {
        $cartes = Carte::with('adherant')->get();
        return view('dashboard.directeur.listecarte', compact('cartes'));
    }

    public function telecharger($id)
{
    $adherant = Adherant::findOrFail($id);

    // Générer le PDF avec DomPDF
    $pdf = \PDF::loadView('munaseb.carte_pdf', compact('adherant'));

    return $pdf->download('carte_'.$adherant->id.'.pdf');
}

}
