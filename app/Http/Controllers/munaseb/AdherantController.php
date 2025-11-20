<?php

namespace App\Http\Controllers\munaseb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\AddEnfant;
use App\Models\espace_adherant\AddConjoint;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\DossierEnfant;
use App\Models\espace_adherant\DossierConjoint;

class AdherantController extends Controller
{
    /* =======================================================
        INSCRIPTION PARENT
    ======================================================= */
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
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

        // Créer l'adhérent
        $adherant = Adherant::create([
            ...$step1,
            ...$step2,
            'photo' => $avatar,
        ]);

        // Stocker les documents dans dossiers_adherant
        $dossier = new DossierAdherant();
        $dossier->adherant_id = $adherant->id;

        if ($request->hasFile('document_cni')) {
            $dossier->document_cni = $request->file('document_cni')->store('documents/cni', 'public');
        }
        if ($request->hasFile('document_attestation')) {
            $dossier->document_attestation = $request->file('document_attestation')->store('documents/attestation', 'public');
        }
        if ($request->hasFile('document_recu')) {
            $dossier->document_recu = $request->file('document_recu')->store('documents/recu', 'public');
        }
        $dossier->save();

        // Supprimer les sessions temporaires
        session()->forget(['step1', 'step2', 'avatar_tmp']);

        // Redirection vers le tableau de bord étudiant
        return redirect()->route('dashboard.etudiant')
            ->with('success', 'Adhésion terminée avec succès ! Bienvenue sur votre tableau de bord.');
    }


    /* =======================================================
        FORMULAIRE ENFANT (PLUSIEURS ETAPES)
    ======================================================= */

    public function showEnfantStep1()
    {
        return view('munaseb.adherant.add_enfantstep1');
    }

    public function postEnfantStep1(Request $request)
    {
        $request->validate([
            'parent_ine' => 'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|in:M,F',
            'dateNaiss' => 'required|date',
            'lieuNaiss' => 'required|string',
            'ine' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Vérification parent
        $parent = Adherant::where('ine', $request->parent_ine)->first();
        if (!$parent) {
            return back()->with('error', "Aucun parent trouvé avec cet INE.");
        }

        // Vérifier si cet enfant existe déjà
        if (AddEnfant::existePourParent($parent->id, $request->nom, $request->prenom, $request->dateNaiss)) {
            return back()->with('error', 'Cet enfant est déjà enregistré pour ce parent.');
        }

        // Sauvegarde
        $data = $request->only('nom', 'prenom', 'sexe', 'dateNaiss', 'lieuNaiss', 'ine');
        $data['parent_id'] = $parent->id;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $enfant = AddEnfant::create($data);

        // Stocker ID enfant
        session(['enfant_id' => $enfant->id]);

        return redirect()->route('munaseb.adherant.add_enfantstep2')
            ->with('success', 'Enfant ajouté avec succès.');
    }

    /* =======================================================
    FORMULAIRE ENFANT — STEP 2
======================================================= */
    public function showEnfantStep2()
    {
        // Vérifier que l’enfant existe dans la session
        if (!session('enfant_id')) {
            return redirect()->route('munaseb.adherant.add_enfantstep1')
                ->with('error', 'Veuillez commencer par l’étape 1.');
        }
        return view('munaseb.adherant.add_enfantstep2');
    }

    public function postEnfantStep2(Request $request)
    {
        $request->validate([
            'typedoc' => 'required',
            'typedoc_parent' => 'required',
            'numdoc' => 'required',
            'numero' => 'required',
            'tel1' => 'required',
            'email' => 'required|email',
        ]);

        $enfant = AddEnfant::find(session('enfant_id'));
        if (!$enfant) {
            return redirect()->route('munaseb.adherant.add_enfantstep1')
                ->with('error', 'Enfant introuvable.');
        }

        $enfant->update($request->all());

        return redirect()->route('munaseb.adherant.add_enfantstep3')
            ->with('success', 'Informations enregistrées.');
    }

    /* =======================================================
    FORMULAIRE ENFANT — STEP 3 (DOCUMENTS)
======================================================= */
    public function showEnfantStep3()
    {
        if (!session('enfant_id')) {
            return redirect()->route('munaseb.adherant.add_enfantstep1')
                ->with('error', 'Veuillez commencer par l’étape 1.');
        }

        return view('munaseb.adherant.add_enfantstep3');
    }

    public function postEnfantStep3(Request $request)
    {
        $enfant = AddEnfant::find(session('enfant_id'));
        if (!$enfant) {
            return redirect()->route('munaseb.adherant.add_enfantstep1')
                ->with('error', 'Enfant introuvable.');
        }

        $dossier = new DossierEnfant();
        $dossier->enfant_id = $enfant->id;

        if ($request->hasFile('doc_extrait')) {
            $dossier->document_extrait_naissance =
                $request->file('doc_extrait')->store('documents/enfants', 'public');
        }
        if ($request->hasFile('doc_cni_parent')) {
            $dossier->document_cni_parent =
                $request->file('doc_cni_parent')->store('documents/parents', 'public');
        }

        $dossier->save();

        // Nettoyer la session
        session()->forget('enfant_id');

        return redirect()->route('munaseb.adherant.add_enfantstep1')
            ->with('success', 'Documents enregistrés avec succès.');
    }



    /* =======================================================
        FORMULAIRE CONJOINT(E)
    ======================================================= */
    public function showConjointStep1()
    {
        return view('munaseb.adherant.add_conjointstep1');
    }

    public function postConjointStep1(Request $request)
    {
        $request->validate([
            'parent_ine' => 'required',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|in:M,F',
            'dateNaiss' => 'required|date',
            'lieuNaiss' => 'required|string',
            'ine' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $parent = Adherant::where('ine', $request->parent_ine)->first();
        if (!$parent) return back()->with('error', "Aucun parent trouvé avec cet INE.");

        if (AddConjoint::existePourParent($parent->id, $request->nom, $request->prenom, $request->dateNaiss)) {
            return back()->with('error', 'Ce conjoint est déjà enregistré pour ce parent.');
        }

        $data = $request->only('nom', 'prenom', 'sexe', 'dateNaiss', 'lieuNaiss', 'ine');
        $data['parent_id'] = $parent->id;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $conjoint = AddConjoint::create($data);
        session(['conjoint_id' => $conjoint->id]);

        return redirect()->route('munaseb.adherant.add_conjointstep2')
            ->with('success', 'Conjoint ajouté avec succès.');
    }

    public function showConjointStep2()
    {
        return view('munaseb.adherant.add_conjointstep2');
    }

    public function postConjointStep2(Request $request)
    {
        $request->validate([
            'typedoc' => 'required',
            'typedoc_conjoint' => 'required',
            'numact' => 'required',
            'numero' => 'required',
            'tel1' => 'required',
            'email' => 'required|email',
        ]);

        AddConjoint::findOrFail(session('conjoint_id'))->update($request->all());

        return redirect()->route('munaseb.adherant.add_conjointstep3');
    }

    public function showConjointStep3()
    {
        return view('munaseb.adherant.adhesionstep3_conjoint');
    }

    public function postConjointStep3(Request $request)
    {
        $conjoint = AddConjoint::find(session('conjoint_id'));
        if (!$conjoint) return redirect()->route('munaseb.adherant.add_conjointstep1')
            ->with('error', 'Vous devez d’abord remplir les informations du conjoint.');

        $request->validate([
            'doc_cni' => 'required|mimes:pdf|max:2048',
            'doc_act' => 'required|mimes:pdf|max:2048',
            'doc_recu' => 'required|mimes:pdf|max:2048',
            'doc_cart' => 'required|mimes:pdf|max:2048',
        ]);

        $dossier = new DossierConjoint();
        $dossier->conjoint_id = $conjoint->id;
        $dossier->document_cni = $request->file('doc_cni')->store('documents/conjoint/cni', 'public');
        $dossier->document_acte_mariage = $request->file('doc_act')->store('documents/conjoint/acte', 'public');
        $dossier->document_recu = $request->file('doc_recu')->store('documents/conjoint/recu', 'public');
        $dossier->document_carte = $request->file('doc_cart')->store('documents/conjoint/carte', 'public');
        $dossier->save();

        session()->forget('conjoint_id');

        return redirect()->route('munaseb.adherant.add_enfantstep1')
            ->with('success', 'Conjoint et documents enregistrés avec succès.');
    }



}
