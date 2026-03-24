<?php

namespace App\Http\Controllers\munaseb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\espace_adherant\DossierEnfant;
use App\Models\espace_adherant\DossierConjoint;
use App\Models\espace_adherant\AddEnfant;
use App\Models\AdherentVisa;
use App\Models\espace_adherant\AddConjoint;
use App\Models\espace_adherant\Filiere;

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
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (Adherant::where('ine', $request->ine)->exists()) {
            return back()->with('error', 'Ce parent est déjà inscrit.');
        }

        session(['step1' => $request->except('photo')]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('tmp/photo', 'public');
            session(['photo_tmp' => $path]);
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
            'nomPrenomscasdebesoin' => 'required|string',
            'contactPersonnecasdebesoin' => 'required|string',
            'lienPersonnecasdebesoin' => 'required|string',
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
        $photo = session('photo_tmp') ?? null;

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
            'photo' => session('photo_tmp'),
        ];

        return view('munaseb.adherant.adhesionstep4', compact('data'));
    }

    // POST Step 4 : soumission finale parent

    public function soumettre(Request $request)
    {
        $step1 = session('step1');
        $step2 = session('step2');
        $step3 = session('step3');
        $photo = session('photo_tmp') ?? null;

        if (!$step1 || !$step2 || !$step3) {
            return redirect()->route('munaseb.adherant.adhesionstep1')
                ->with('error', 'Veuillez remplir toutes les étapes avant de soumettre.');
        }

        $code_unique = 'PARENT-' . strtoupper(uniqid());

        // ===============================
        // 🔹 1. CREATION ADHERANT
        // ===============================
        $adherant = Adherant::create([
            ...$step1,
            ...$step2,
            'photo' => $photo,
            'code_unique' => $code_unique,
            'statut' => 'En attente',
            'date_soumission' => now(),
        ]);

        // ===============================
        // 2. CREATION WORKFLOW VISA
        // ===============================
        $workflow = [
            'regie_recette',
            'liquidation_production',
            'directeur'
        ];
        foreach ($workflow as $etape) {
            AdherentVisa::create([
                'adherant_id' => $adherant->id,
                'type' => 'parent',
                'etape' => $etape,
                'decision' => 'en_attente'
            ]);
        }
        // ===============================
        // 🔹 3. CREATION DOSSIER
        // ===============================
        $dossier = new DossierAdherant();
        $dossier->adherant_id = $adherant->id;
        $dossier->document_cni = $step3['document_cni'] ?? null;
        $dossier->document_attestation = $step3['document_attestation'] ?? null;
        $dossier->document_recu = $step3['document_recu'] ?? null;
        $dossier->save();

        // ===============================
        // 🔹 4. NETTOYAGE SESSION
        // ===============================
        session()->forget(['step1', 'step2', 'step3', 'photo_tmp']);

        /* ===============================
         5. REDIRECTION
         ===============================*/
        return redirect()->route('dashboard.etudiant')
            ->with('success', 'Adhésion parent soumise avec succès !');
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        session(['child_step1' => $request->only(['nom', 'prenom', 'sexe', 'dateNaiss', 'lieuNaiss', 'ine'])]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('tmp/child/photo', 'public');
            session(['child_photo_tmp' => $path]);
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
            'typedoc' => 'required|string',
            'numdoc' => 'required|string',
            'tel1' => 'required|string',
            'email' => 'required|email',
        ]);

        session(['child_step2' => $request->only(['typedoc', 'numdoc', 'tel1', 'email'])]);

        return redirect()->route('enfant.step3');
    }

    public function enfantStep3()
    {
        return view('munaseb.adherant.add_enfantstep3');
    }

    public function postEnfantStep3(Request $request)
    {
        $request->validate([
            'doc_extrait' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_cni_parent' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'document_recu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'document_carte' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $step3 = [
            'document_extrait_naissance' => $request->file('doc_extrait')->store('tmp/child/documents', 'public'),
            'document_cni_parent' => $request->file('doc_cni_parent')->store('tmp/child/documents', 'public'),
            'document_recu' => $request->file('document_recu')->store('tmp/child/documents', 'public'),
            'document_carte' => $request->file('document_carte')->store('tmp/child/documents', 'public'),
        ];

        session(['child_step3' => $step3]);

        return redirect()->route('enfant.step4');
    }

    public function enfantSoumettre(Request $request)
    {
        $step1 = session('child_step1');
        $step2 = session('child_step2');
        $step3 = session('child_step3');
        $avatar = session('child_photo_tmp') ?? null;

        if (!$step1 || !$step2 || !$step3) {
            return redirect()->route('enfant.step1')->with('error', 'Toutes les étapes doivent être complétées.');
        }

        // Vérification mutualiste
        $parent = auth()->user()->adherant;
        if (!$parent || $parent->statut !== 'Mutualiste') {
            return redirect()->route('enfant.step1')->with('error', 'Impossible d’ajouter un enfant : le parent doit être mutualiste.');
        }

        $code_unique = 'ENF-' . strtoupper(uniqid());

        // Création enfant
        $enfant = AddEnfant::create(array_merge($step1, $step2, [
            'parent_id' => $parent->id,
            'photo' => $avatar,
            'code_unique' => $code_unique,
            'statut' => 'En attente',
            'date_soumission' => now(),
        ]));

        // Création dossier enfant
        DossierEnfant::create([
            'adherant_id' => $enfant->id,
            'document_extrait_naissance' => $step3['document_extrait_naissance'] ?? null,
            'document_cni_parent' => $step3['document_cni_parent'] ?? null,
            'document_recu' => $step3['document_recu'] ?? null,
            'document_carte' => $step3['document_carte'] ?? null,
        ]);

        // Workflow visas
        foreach (['regie_recette', 'liquidation_production', 'directeur'] as $etape) {
            AdherentVisa::create([
                'adherant_id' => $enfant->id,
                'type' => 'enfant',
                'etape' => $etape,
                'decision' => 'en_attente',
            ]);
        }

        // Nettoyage sessions
        session()->forget(['child_step1', 'child_step2', 'child_step3', 'child_avatar_tmp']);

        return redirect()->route('dashboard.etudiant')->with('success', 'Demande enfant soumise avec succès !');
    }

    /*   =========
             recapitulatigf
        ===========*/
    public function enfantStep4()
    {
        // Vérifie que toutes les étapes précédentes existent en session
        if (!session('child_step1') || !session('child_step2') || !session('child_step3')) {
            return redirect()->route('enfant.step1')->with('error', 'Veuillez remplir toutes les étapes.');
        }

        $data = [
            'step1' => session('child_step1'),
            'step2' => session('child_step2'),
            'step3' => session('child_step3'),
            'photo' => session('child_photo_tmp') ?? null,
        ];

        return view('munaseb.adherant.add_enfantstep4', compact('data'));
    }

    /*====================================================
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        session(['spouse_step1' => $request->except('photo')]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('tmp/spouse/photo', 'public');
            session(['spouse_photo_tmp' => $path]);
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
        // Validation
        $request->validate([
            'doc_cni' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_act' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_recu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'doc_cart' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $step3 = [
            'document_cni' => $request->file('doc_cni')->store('tmp/spouse/documents', 'public'),
            'document_acte_mariage' => $request->file('doc_act')->store('tmp/spouse/documents', 'public'),
            'document_recu' => $request->file('doc_recu')->store('tmp/spouse/documents', 'public'),
            'document_carte' => $request->file('doc_cart')->store('tmp/spouse/documents', 'public'),
        ];

        session(['spouse_step3' => $step3]);

        return redirect()->route('conjoint.step4');
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

        // Vérification mutualiste
        $parent = auth()->user()->adherant;
        if (!$parent || $parent->statut !== 'Mutualiste') {
            return redirect()->route('conjoint.step1')->with('error', 'Impossible d’ajouter un conjoint : le parent doit être mutualiste.');
        }

        $code_unique = 'CON-' . strtoupper(uniqid());

        // Création conjoint
        $conjoint = AddConjoint::create(array_merge($step1, $step2, [
            'parent_id' => $parent->id,
            'photo' => $photo,
            'code_unique' => $code_unique,
            'statut' => 'En attente',
            'date_soumission' => now(),
        ]));

        // Création dossier conjoint
        DossierConjoint::create([
            'conjoint_id' => $conjoint->id,
            'document_cni' => $step3['document_cni'] ?? null,
            'document_acte_mariage' => $step3['document_acte_mariage'] ?? null,
            'document_recu' => $step3['document_recu'] ?? null,
            'document_carte' => $step3['document_carte'] ?? null,
        ]);

        // Workflow visas
        foreach (['regie_recette', 'liquidation_production', 'directeur'] as $etape) {
            AdherentVisa::create([
                'adherant_id' => $conjoint->id,
                'type' => 'conjoint',
                'etape' => $etape,
                'decision' => 'en_attente',
            ]);
        }

        // Nettoyage sessions
        session()->forget(['spouse_step1', 'spouse_step2', 'spouse_step3', 'spouse_avatar_tmp']);

        return redirect()->route('dashboard.etudiant')->with('success', 'Demande conjoint soumise avec succès !');
    }

    /* =================
       recaputilatif 
       ============   */
    public function conjointStep4()
    {
        if (!session('spouse_step1') || !session('spouse_step2') || !session('spouse_step3')) {
            return redirect()->route('conjoint.step1')->with('error', 'Veuillez remplir toutes les étapes.');
        }

        $data = [
            'step1' => session('spouse_step1'),
            'step2' => session('spouse_step2'),
            'step3' => session('spouse_step3'),
            'avatar' => session('spouse_avatar_tmp') ?? null,
        ];

        return view('munaseb.adherant.add_conjointstep4', compact('data'));
    }
    /*===================
           logique de modiffication demande traiter
             ============*/
    public function indexTraites()
    {
        // Récupérer tous les adhérents traités (valide ou rejeté)
        $adherants = Adherant::with(['dossier', 'visas'])->get();

        // Rôle de l'utilisateur actuel
        $userRole = Auth::user()->roles->first()->name ?? null;

        foreach ($adherants as $adherant) {
            // Par défaut, on ne peut pas modifier
            $adherant->can_edit = false;

            // On récupère le dernier visa traité
            $lastVisa = $adherant->visas->sortByDesc('created_at')->first();

            // Condition pour savoir si l'utilisateur peut modifier
            if ($lastVisa) {
                // Si le dernier visa n'a pas encore été validé par le supérieur suivant
                // et que le statut du dernier visa est "en_attente" pour l'étape correspondante
                $currentVisa = $adherant->visas
                    ->where('etape', $userRole)
                    ->first();

                if ($currentVisa && $currentVisa->decision === 'en_attente') {
                    $adherant->can_edit = true;
                }
            } else {
                // Aucun visa créé → l'utilisateur peut modifier avant soumission complète
                $adherant->can_edit = true;
            }
        }

        return view('regie.adherant.traites', compact('adherants'));
    }

    // Ajax filiere//

    public function getFilieres($universiteId)
    {
        // Récupère toutes les filières liées à l'université
        $filieres = Filiere::where('idUniversite', $universiteId)->get(['id', 'nom']);

        // Renvoie en JSON
        return response()->json($filieres);
    }
    /*=========
        detaill
     ===========*/

    public function showDetail($id)
    {
        $adherant = Adherant::with(['dossier', 'enfants.dossier', 'conjoints.dossier'])->findOrFail($id);

        // Logique pour savoir si la demande est modifiable
        // Exemple :
        $editable = false;

        // Si aucun visa n'est encore validé, on peut éditer
        $visaTraites = AdherentVisa::where('demande_id', $adherant->id)
            ->where('decision', 'valide')
            ->count();

        if ($visaTraites === 0) {
            $editable = true;
        }

        // Tu peux aussi définir séparément pour valider/rejeter
        $canValider = $editable;
        $canRejeter = $editable;

        return view('regie.adherant.detail', compact('adherant', 'editable', 'canValider', 'canRejeter'));
    }
    /*   ===============
          Demande en attentes et traiter 
          ===========================*/

    public function demandesSelonRole()
    {
        $user = Auth::user();
        $userRole = $user->roles->first()->name ?? null;

        if (!$userRole) {
            abort(403, 'Rôle non défini');
        }

        $adherants = Adherant::with('visas', 'dossier')->get();

        // Filtrage selon le rôle connecté
        $filtered = $adherants->filter(function ($a) use ($userRole) {
            $previousStepValid = true;

            switch ($userRole) {
                case 'regie_recette':
                    // Régie voit tout, aucune étape précédente à vérifier
                    break;

                case 'liquidation_production':
                    // Liquidation ne voit que ce que Régie a validé
                    $previousStepValid = optional($a->visas->where('etape', 'regie_recette')->first())->decision === 'valide';
                    break;

                case 'directeur':
                    // Directeur ne voit que ce que Liquidation a validé
                    $previousStepValid = optional($a->visas->where('etape', 'liquidation_production')->first())->decision === 'valide';
                    break;
            }

            // Visa du rôle courant
            $currentVisa = $a->visas->where('etape', $userRole)->first();
            $a->canAct = $currentVisa && $currentVisa->decision === 'en_attente';
            $a->visaDecision = $currentVisa->decision ?? 'en_attente';

            return $previousStepValid;
        });

        // Séparer demandes en attente / traitées
        $enAttente = $filtered->filter(fn($a) => $a->visaDecision === 'en_attente');
        $traitees  = $filtered->filter(fn($a) => in_array($a->visaDecision, ['valide', 'rejete']));

        // 🔹 Retour spécifique selon rôle pour utiliser des vues différentes si nécessaire
        switch ($userRole) {
            case 'regie_recette':
                return view('regie.adherant.non_valide', compact('enAttente', 'traitees'));
            case 'liquidation_production':
                return view('liquidation.adherant.non_valide', compact('enAttente', 'traitees'));
            case 'directeur':
                return view('directeur.adherant.non_valide', compact('enAttente', 'traitees'));
        }
    }
    /* =======================================================
       ====================== VERIFICATION DEMANDE ===========
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

        $adherant = Adherant::with(['universite', 'filiere', 'carte', 'dossier'])
            ->where('ine', $request->ine)
            ->whereYear('dateNaiss', $request->annee_naissance)
            ->first();

        if (!$adherant) {
            return redirect()->back()->with('error', 'Aucune demande trouvée avec ces informations.');
        }

        return view('munaseb.statut_adherant.statut_adhesion', compact('adherant'));
    }

    /*====================================
      mes historique de trairement
      ====================================
      */
    public function mesDemandes()
    {
        $userRole = Auth::user()->roles->first()->name ?? null;

        // Récupère tous les adhérents qui concernent ce rôle
        $adherants = Adherant::whereHas('visas', function ($query) use ($userRole) {
            $query->where('etape', $userRole);
        })
            ->with(['visas' => function ($query) use ($userRole) {
                // On ne prend que le visa correspondant au rôle courant
                $query->where('etape', $userRole);
            }, 'dossier'])
            ->get();

        // On peut ensuite séparer les demandes en attente et celles déjà traitées
        $enAttente = $adherants->filter(function ($adherant) {
            return $adherant->visas->first()->decision === 'en_attente';
        });

        $traitees = $adherants->filter(function ($adherant) {
            return in_array($adherant->visas->first()->decision, ['valide', 'rejete']);
        });

        return view('regie.adherant.mes_demandes', compact('enAttente', 'traitees'));
    }
}
