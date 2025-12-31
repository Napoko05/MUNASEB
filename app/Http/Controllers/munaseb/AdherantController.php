<?php

namespace App\Http\Controllers\munaseb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\Enfant;
use App\Models\espace_adherant\Conjoint;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\DossierEnfant;
use App\Models\espace_adherant\DossierConjoint;

class AdherantController extends Controller
{
    /* =======================================================
       ====================== PARENT ========================
    ======================================================= */

    // Step 1 : infos personnelles
    public function step1()
    {
        return view('munaseb.adherant.adhesionstep1');
    }

    public function postParentStep1(Request $request)
    {
        $request->validate([
            'ine' => 'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|in:M,F',
            'dateNaiss' => 'required|date',
            'lieuNaiss' => 'required|string',
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (Adherant::where('ine', $request->ine)->exists()) {
            return back()->with('error', 'Ce parent est déjà inscrit.');
        }

        session(['step1' => $request->except('avatar')]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('tmp/avatar', 'public');
            session(['avatar_tmp' => $path]);
        }

        return redirect()->route('munaseb.adherant.adhesionstep2');
    }

    // Step 2 : infos complémentaires
    public function step2()
    {
        return view('munaseb.adherant.adhesionstep2');
    }

    public function postParentStep2(Request $request)
    {
        $request->validate([
            'typedoc' => 'required',
            'numdoc' => 'required',
            'tel1' => 'required',
            'email' => 'required|email',
            'idUniversite' => 'required',
            'idFiliere' => 'required',
            'nomPrenomscasdebesoin' => 'required',
            'contactPersonnecasdebesoin' => 'required',
            'lienPersonnecasdebesoin' => 'required',
        ]);

        session(['step2' => $request->all()]);
        return redirect()->route('munaseb.adherant.adhesionstep3');
    }

    // Step 3 : upload documents
    public function step3()
    {
        return view('munaseb.adherant.adhesionstep3');
    }

    public function postParentStep3(Request $request)
    {
        $step1 = session('step1');
        $step2 = session('step2');
        $avatar = session('avatar_tmp') ?? null;

        if (!$step1 || !$step2) {
            return redirect()->route('munaseb.adherant.adhesionstep1')
                ->with('error', 'Vous devez d’abord remplir les étapes 1 et 2');
        }

        $step3 = [];

        if ($request->hasFile('document_cni')) {
            $step3['document_cni'] = $request->file('document_cni')->store('tmp/documents/CNIB', 'public');
        }
        if ($request->hasFile('document_attestation')) {
            $step3['document_attestation'] = $request->file('document_attestation')->store('tmp/documents/Attestation', 'public');
        }
        if ($request->hasFile('document_recu')) {
            $step3['document_recu'] = $request->file('document_recu')->store('tmp/documents/Recu', 'public');
        }

        session(['step3' => $step3]);

        return redirect()->route('munaseb.adherant.adherantstep4');
    }

    // Step 4 : récapitulatif et confirmation
    public function showStep4()
    {
        if (!session('step1') || !session('step2') || !session('step3')) {
            return redirect()->route('munaseb.adherant.adhesionstep1')
                ->with('error', 'Veuillez remplir toutes les étapes.');
        }

        $data = [
            'step1' => session('step1'),
            'step2' => session('step2'),
            'step3' => session('step3'),
            'avatar' => session('avatar_tmp'),
        ];

        return view('munaseb.adherant.adhesionstep4', compact('data'));
    }

    // POST Step 4 : soumission finale parent
    public function soumettre(Request $request)
    {
        $step1 = session('step1');
        $step2 = session('step2');
        $step3 = session('step3');
        $avatar = session('avatar_tmp') ?? null;

        if (!$step1 || !$step2 || !$step3) {
            return redirect()->route('munaseb.adherant.adhesionstep1')
                ->with('error', 'Veuillez remplir toutes les étapes avant de soumettre.');
        }

        $code_unique = 'PARENT-' . strtoupper(uniqid());

        // Création Adhérant
        $adherant = Adherant::create([
            ...$step1,
            ...$step2,
            'photo' => $avatar,
            'code_unique' => $code_unique,
            'statut' => 'En attente',
            'date_soumission' => now(),
        ]);

        // Création Dossier
        $dossier = new DossierAdherant();
        $dossier->adherant_id = $adherant->id;
        $dossier->document_cni = $step3['document_cni'] ?? null;
        $dossier->document_attestation = $step3['document_attestation'] ?? null;
        $dossier->document_recu = $step3['document_recu'] ?? null;
        $dossier->save();

        // Nettoyer les sessions
        session()->forget(['step1', 'step2', 'step3', 'avatar_tmp']);

        return redirect()->route('dashboard.etudiant')->with('success', 'Adhésion parent soumise avec succès !');
    }
    /* =======================================================
   ====================== ENFANT =========================
   ======================================================= */

public function enfantStep1()
{
    return view('munaseb.adherant.add_enfantstep1');
}

public function postEnfantStep1(Request $request)
{
    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'sexe' => 'required|in:M,F',
        'dateNaiss' => 'required|date',
        'lieuNaiss' => 'required|string',
        'ine' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    session(['child_step1' => $request->except('avatar')]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('tmp/child/avatar', 'public');
        session(['child_avatar_tmp' => $path]);
    }

    return redirect()->route('enfant.step2');
}

public function enfantStep2()
{
    return view('munaseb.adherant.add_enfantstep2');
}

public function postEnfantStep2(Request $request)
{
    $request->validate([
        'typedoc' => 'required',
        'numdoc' => 'required',
        'tel1' => 'required',
        'email' => 'required|email',
    ]);

    session(['child_step2' => $request->all()]);
    return redirect()->route('enfant.step3');
}

public function enfantStep3()
{
    return view('munaseb.adherant.add_enfantstep3');
}

public function postEnfantStep3(Request $request)
{
    $step3 = [];

    if ($request->hasFile('doc_extrait')) {
        $step3['doc_extrait'] = $request->file('doc_extrait')->store('tmp/child/documents', 'public');
    }
    if ($request->hasFile('doc_cni_parent')) {
        $step3['doc_cni_parent'] = $request->file('doc_cni_parent')->store('tmp/child/documents', 'public');
    }
    if ($request->hasFile('document_recu')) {
        $step3['document_recu'] = $request->file('document_recu')->store('tmp/child/documents', 'public');
    }
    if ($request->hasFile('document_carte')) {
        $step3['document_carte'] = $request->file('document_carte')->store('tmp/child/documents', 'public');
    }

    session(['child_step3' => $step3]);
    return redirect()->route('enfant.step4');
}

public function enfantStep4()
{
    if (!session('child_step1') || !session('child_step2') || !session('child_step3')) {
        return redirect()->route('enfant.step1')->with('error', 'Veuillez remplir toutes les étapes.');
    }

    $data = [
        'step1' => session('child_step1'),
        'step2' => session('child_step2'),
        'step3' => session('child_step3'),
        'avatar' => session('child_avatar_tmp'),
    ];

    return view('munaseb.adherant.add_enfantstep4', compact('data'));
}

public function enfantSoumettre(Request $request)
{
    $step1 = session('child_step1');
    $step2 = session('child_step2');
    $step3 = session('child_step3');
    $avatar = session('child_avatar_tmp') ?? null;

    if (!$step1 || !$step2 || !$step3) {
        return redirect()->route('enfant.step1')->with('error', 'Toutes les étapes doivent être complétées.');
    }

    $code_unique = 'ENF-' . strtoupper(uniqid());

    $enfant = Enfant::create([
        ...$step1,
        ...$step2,
        'avatar' => $avatar,
        'code_unique' => $code_unique,
        'statut' => 'En attente',
        'date_soumission' => now(),
    ]);

    $dossier = new DossierEnfant();
    $dossier->enfant_id = $enfant->id;
    $dossier->doc_extrait = $step3['doc_extrait'] ?? null;
    $dossier->doc_cni_parent = $step3['doc_cni_parent'] ?? null;
    $dossier->document_recu = $step3['document_recu'] ?? null;
    $dossier->document_carte = $step3['document_carte'] ?? null;
    $dossier->save();

    session()->forget(['child_step1', 'child_step2', 'child_step3', 'child_avatar_tmp']);

    return redirect()->route('dashboard.etudiant')->with('success', 'Demande enfant soumise avec succès !');
}
/* =======================================================
   ====================== CONJOINT =======================
   ======================================================= */

public function conjointStep1()
{
    return view('munaseb.adherant.add_conjointstep1');
}

public function postConjointStep1(Request $request)
{
    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'sexe' => 'required|in:M,F',
        'dateNaiss' => 'required|date',
        'lieuNaiss' => 'required|string',
        'ine' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    session(['spouse_step1' => $request->except('avatar')]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('tmp/spouse/avatar', 'public');
        session(['spouse_avatar_tmp' => $path]);
    }

    return redirect()->route('conjoint.step2');
}

public function conjointStep2()
{
    return view('munaseb.adherant.add_conjointstep2');
}

public function postConjointStep2(Request $request)
{
    $request->validate([
        'typedoc' => 'required',
        'numdoc' => 'required',
        'tel1' => 'required',
        'email' => 'required|email',
    ]);

    session(['spouse_step2' => $request->all()]);
    return redirect()->route('conjoint.step3');
}

public function conjointStep3()
{
    return view('munaseb.adherant.add_conjointstep3');
}

public function postConjointStep3(Request $request)
{
    $step3 = [];

    if ($request->hasFile('doc_cni')) $step3['doc_cni'] = $request->file('doc_cni')->store('tmp/spouse/documents', 'public');
    if ($request->hasFile('doc_act')) $step3['doc_act'] = $request->file('doc_act')->store('tmp/spouse/documents', 'public');
    if ($request->hasFile('document_recu')) $step3['document_recu'] = $request->file('document_recu')->store('tmp/spouse/documents', 'public');
    if ($request->hasFile('document_carte')) $step3['document_carte'] = $request->file('document_carte')->store('tmp/spouse/documents', 'public');

    session(['spouse_step3' => $step3]);
    return redirect()->route('conjoint.step4');
}

public function conjointStep4()
{
    if (!session('spouse_step1') || !session('spouse_step2') || !session('spouse_step3')) {
        return redirect()->route('conjoint.step1')->with('error', 'Veuillez remplir toutes les étapes.');
    }

    $data = [
        'step1' => session('spouse_step1'),
        'step2' => session('spouse_step2'),
        'step3' => session('spouse_step3'),
        'avatar' => session('spouse_avatar_tmp'),
    ];

    return view('munaseb.adherant.add_conjointstep4', compact('data'));
}

public function conjointSoumettre(Request $request)
{
    $step1 = session('spouse_step1');
    $step2 = session('spouse_step2');
    $step3 = session('spouse_step3');
    $avatar = session('spouse_avatar_tmp') ?? null;

    if (!$step1 || !$step2 || !$step3) {
        return redirect()->route('conjoint.step1')->with('error', 'Toutes les étapes doivent être complétées.');
    }

    $code_unique = 'CON-' . strtoupper(uniqid());

    $conjoint = Conjoint::create([
        ...$step1,
        ...$step2,
        'avatar' => $avatar,
        'code_unique' => $code_unique,
        'statut' => 'En attente',
        'date_soumission' => now(),
    ]);

    $dossier = new DossierConjoint();
    $dossier->conjoint_id = $conjoint->id;
    $dossier->document_cni = $step3['doc_cni'] ?? null;
    $dossier->document_act = $step3['doc_act'] ?? null;
    $dossier->document_recu = $step3['document_recu'] ?? null;
    $dossier->document_carte = $step3['document_carte'] ?? null;
    $dossier->save();
    session()->forget(['spouse_step1', 'spouse_step2', 'spouse_step3', 'spouse_avatar_tmp']);   
    return redirect()->route('dashboard.etudiant')->with('success', 'Demande conjoint soumise avec succès !');  
}

    /* =======================================================
       ====================== VERIFICATION DEMANDE ========================
       ======================================================= */
    public function formVerifierDemande()
    {
        return view('munaseb.statut_adherant.statut_adhesion');
    }

    // Vérifie la demande via INE + année de naissance
    public function verifierDemande(Request $request)
    {
        $request->validate([
            'ine' => 'required|string',
            'annee_naissance' => 'required|digits:4',
        ]);

        $adherant = Adherant::with(['universites', 'filieres', 'carte', 'dossier'])
            ->where('ine', $request->ine)
            ->whereYear('dateNaiss', $request->annee_naissance)
            ->first();

        if (!$adherant) {
            return redirect()->back()->with('error', 'Aucune demande trouvée avec ces informations.');
        }

        return view('munaseb.statut_adherant.statut_adhesion', compact('adherant'));
    }
}
