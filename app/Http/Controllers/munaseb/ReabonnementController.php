<?php

namespace App\Http\Controllers\munaseb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\DossierAdherant;
use Illuminate\Validation\Rule;

class ReabonnementController extends Controller
{
    // Step 1 : Lecture seule
    public function step1()
    {
        $adherant = Adherant::where('user_id', auth()->id())->firstOrFail();
        return view('munaseb.reabonnement.reabonnement_step1', compact('adherant'));
    }

    public function postStep1(Request $request)
    {
        return redirect()->route('munaseb.reabonnement.reabonnement_step2');
    }

    // Step 2 : Formulaire modification
    public function step2()
    {
        $adherant = Adherant::where('user_id', auth()->id())->firstOrFail();
        return view('munaseb.reabonnement.reabonnement_step2', compact('adherant'));
    }

    public function postStep2(Request $request)
    {
        $adherant = Adherant::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'tel1' => 'required',
            'tel2' => 'nullable',
            'email' => ['required','email', Rule::unique('adherants', 'email')->ignore($adherant->id)],
            'idUniversite' => 'required',
            'idFiliere' => 'required',
        ]);

        $adherant->update($request->only(['tel1', 'tel2', 'email', 'idUniversite', 'idFiliere']));

        return redirect()->route('munaseb.reabonnement.reabonnement_step3')->with('success', 'Informations mises à jour');
    }

    // Step 3 : Upload documents
    public function step3()
    {
        return view('munaseb.reabonnement.reabonnement_step3');
    }

    public function postStep3(Request $request)
    {
        $adherant = Adherant::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'document_cni' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'document_attestation' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'document_recu' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $dossier = new DossierAdherant();
        $dossier->adherant_id = $adherant->id;

        $dossier->document_cni = $request->file('document_cni')->store('documents/cni', 'public');
        $dossier->document_attestation = $request->file('document_attestation')->store('documents/attestation', 'public');
        $dossier->document_recu = $request->file('document_recu')->store('documents/recu', 'public');

        $dossier->save();

        return redirect()->route('dashboard.etudiant')->with('success', 'Réabonnement terminé !');
    }
}
