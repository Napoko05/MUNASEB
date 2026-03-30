<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Dashboard\EtudiantController;
use App\Http\Controllers\Dashboard\DirecteurController;
use App\Http\Controllers\Dashboard\RegieController;
use App\Http\Controllers\munaseb\AdherantController;
use App\Http\Controllers\munaseb\ReabonnementController;
use App\Http\Controllers\Dashboard\CarteController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Dashboard\AdhesionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Dashboard\LiquidationController;

// Page d'accueil
Route::get('/', fn() => view('espace_munaseb.index'));

// Authentification
Auth::routes();

// Dashboard Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes CRUD pour utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    // Dashboards selon les rôles
    Route::get('/dashboard/etudiant', [EtudiantController::class, 'index'])->name('dashboard.etudiant');
    Route::get('/dashboard/directeur', [DirecteurController::class, 'index'])->name('dashboard.directeur');
    Route::get('/dashboard/regie_recette', [RegieController::class, 'dashboard'])->name('dashboard.regie');
});


Route::middleware('auth')->get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
//creation agent
Route::prefix('admin/agents')->middleware(['auth'])->group(function () {
    Route::get('create', [AgentController::class, 'create'])->name('admin.agents.create');
    Route::post('step2', [AgentController::class, 'step2'])->name('admin.agents.step2');
    Route::get('step2', [AgentController::class, 'step2View'])->name('admin.agents.step2.view');
    Route::post('store', [AgentController::class, 'store'])->name('admin.agents.store');
});

/*=== route directeur
===*/
Route::middleware(['auth', 'role:directeur'])
    ->prefix('directeur')
    ->name('directeur.')
    ->group(function () {

        Route::get('/', [DirecteurController::class, 'index'])->name('dashboard');

        // Cartes
        Route::post('/carte/{id}/signer', [DirecteurController::class, 'signerCarte'])->name('carte_signer');
        Route::get('/carte/{id}/signer', [DirecteurController::class, 'signerCarte'])->name('cartes.signer');
        Route::get('/cartes', [DirecteurController::class, 'listeCartes'])->name('cartes.liste');

        // Adhérant
        Route::post('/adherant/{id}/valider', [DirecteurController::class, 'validerAdherant'])->name('adherant.valider');
        Route::post('/adherant/{id}/rejeter', [DirecteurController::class, 'rejeterAdherant'])->name('adherant.rejeter');

        // Enfant
        Route::post('/enfant/{id}/valider', [DirecteurController::class, 'validerEnfant'])->name('enfant.valider');
        Route::post('/enfant/{id}/rejeter', [DirecteurController::class, 'rejeterEnfant'])->name('enfant.rejeter');

        // Conjoint
        Route::post('/conjoint/{id}/valider', [DirecteurController::class, 'validerConjoint'])->name('conjoint.valider');
        Route::post('/conjoint/{id}/rejeter', [DirecteurController::class, 'rejeterConjoint'])->name('conjoint.rejeter');

        // Documents
        Route::get('/dossier/{id}', [DirecteurController::class, 'voirDocument'])->name('dossier.detail');
    });
Route::middleware('auth')->group(function () {
    Route::get('/carte/{id}/telecharger', [CarteController::class, 'telecharger'])
        ->name('carte.telecharger');
});

/*===========================
 Routes Régie de recette
=============================*/

Route::middleware(['auth', 'role:regie_recette'])->prefix('regie')->name('regie.')->group(function () {
    Route::get('/dashboard', [RegieController::class, 'dashboard'])->name('dashboard');


    // =========================
    // ADHERENTS
    // =========================

    // Liste des adhérents non validés (en attente)
    Route::get('adhesions/non-validees', [RegieController::class, 'adherantsNonValides'])
        ->name('adherants.nonvalidees');

    // Liste des adhérents déjà traités (validés ou rejetés)
    Route::get('adhesions/traitees', [RegieController::class, 'adherantsTraitees'])
        ->name('adherants.traitees');

    // Détails d'un adhérent
    Route::get('adhesion/{id}', [RegieController::class, 'detailAdherant'])
        ->name('adherant.detail');

    // Valider un adhérent
    Route::post('adhesion/{id}/valider', [RegieController::class, 'validerAdherant'])
        ->name('adherant.valider');

    // Rejeter un adhérent
    Route::post('adhesion/{id}/rejeter', [RegieController::class, 'rejeterAdherant'])
        ->name('adherant.rejeter');

    // Modifier un adhérent
    Route::get('adhesion/{id}/modifier', [RegieController::class, 'modifierAdherant'])
        ->name('adherant.modifier');

    // =========================
    // ENFANTS
    // =========================

    Route::get('enfant/{id}', [RegieController::class, 'detailEnfant'])
        ->name('enfant.detail');

    Route::post('enfant/{id}/valider', [RegieController::class, 'validerEnfant'])
        ->name('enfant.valider');

    Route::post('enfant/{id}/rejeter', [RegieController::class, 'rejeterEnfant'])
        ->name('enfant.rejeter');

    // =========================
    // CONJOINTS
    // =========================

    Route::get('conjoint/{id}', [RegieController::class, 'detailConjoint'])
        ->name('conjoint.detail');

    Route::post('conjoint/{id}/valider', [RegieController::class, 'validerConjoint'])
        ->name('conjoint.valider');

    Route::post('conjoint/{id}/rejeter', [RegieController::class, 'rejeterConjoint'])
        ->name('conjoint.rejeter');
});
/*============================
   route pour liquidation & production
   =====================*/

Route::middleware(['auth', 'role:liquidation_production'])
    ->prefix('liquidation')->name('liquidation.')->group(function () {
        // ======================
        // DASHBOARD
        // ======================
        Route::get('/', [LiquidationController::class, 'index'])
            ->name('dashboard');
        //Dashboard
        Route::get('/adhesions/en-cours', [AdhesionController::class, 'enCours'])->name('adhesions.en_cours');
        Route::get('/adhesions/traitees', [LiquidationController::class, 'adhesionsTraitees'])->name('adhesions.traitees');
        Route::get('/adhesion/{adherant}', [LiquidationController::class, 'detailProfil'])->name('adhesion.detail');
        Route::post('/adhesion/{adherant}/rejeter', [LiquidationController::class, 'rejeterAdherant'])->name('adhesion.rejeter');
        Route::get('/cartes/a-creer', [LiquidationController::class, 'cartesNonTraite'])->name('cartes.a_creer');
        Route::post('/adherant/{adherant}/creer-carte', [CarteController::class, 'creer'])->name('cartes.creer');
        Route::get('/cartes', [CarteController::class, 'listeCartes'])->name('cartes.liste');
        Route::get('/cartes/{carte}', [LiquidationController::class, 'voirCarte'])->name('cartes.show');

        // ====================DOCUMENTS===================
        Route::get('/dossier/{adherant}/document', [LiquidationController::class, 'voirDocument'])->name('dossier.voirDocument');
        Route::post('/creer-carte/{id}', [LiquidationController::class, 'creerCarte'])
            ->name('creerCarte');
        Route::post('/rejeter/{id}', [LiquidationController::class, 'rejeterInfos'])
            ->name('rejeter');

        // ====================== STATS======================
        Route::get('/stats', [LiquidationController::class, 'stats'])
            ->name('stats');
        Route::get('/liquidation/carte/{id}/edit', [LiquidationController::class, 'editCarte'])
            ->name('carte.edit');
        // Mettre à jour une carte (la route qui manquait)
        Route::put('carte/{adherant}', [LiquidationController::class, 'updateCarte'])
            ->name('carte.update');
    });

//============================= 
//  Routes Trésorier
//=========================================
Route::middleware(['auth', 'role:tresorier'])->group(function () {
    Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
});

// Routes Étudiant
Route::middleware(['auth', 'role:etudiant'])
    ->prefix('dashboard/etudiant')
    ->name('etudiant.')
    ->group(function () {
        Route::get('/adhesion/nouvelle', [AdhesionController::class, 'new_adhesion'])->name('adhesion.nouvelle');
        Route::get('/adhesion/renouvellement', [AdhesionController::class, 'renouvellement'])->name('adhesion.renouvellement');
        Route::get('/adhesion/remboursement', [AdhesionController::class, 'remboursement'])->name('adhesion.remboursement');
        Route::get('/profile/edit', [AdhesionController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/edit', [AdhesionController::class, 'update'])->name('profile.update');
        Route::get('/mes-bons', [AdhesionController::class, 'mesbons'])->name('mesbons');
        Route::get('/historique', [AdhesionController::class, 'historique'])->name('historique');
    });

// Routes adhérents généraux
Route::prefix('adherant')->name('adherant.')->group(function () {
    Route::get('/dashboard/etudiant', [AdhesionController::class, 'index'])->name('dashboard');
    Route::get('/nouveau', [AdhesionController::class, 'create'])->name('create');
    Route::post('/store', [AdhesionController::class, 'store'])->name('store');
    Route::get('/{id}', [AdhesionController::class, 'show'])->name('show');
});

/*========================
Processus d’adhésion multi-étapes (Parent, Enfant, Conjoint)
=====*/
Route::prefix('munaseb/adherant')->name('munaseb.adherant.')->group(function () {
    Route::get('step1', [AdherantController::class, 'step1'])->name('adhesionstep1');
    Route::post('step1', [AdherantController::class, 'postParentStep1'])->name('postParentStep1');

    Route::get('step2', [AdherantController::class, 'step2'])->name('adhesionstep2');
    Route::post('step2', [AdherantController::class, 'postParentStep2'])->name('postParentStep2');

    Route::get('step3', [AdherantController::class, 'step3'])->name('adhesionstep3');
    Route::post('step3', [AdherantController::class, 'postParentStep3'])->name('postParentStep3');

    Route::get('step4', [AdherantController::class, 'showStep4'])->name('adherantstep4');

    Route::post('step4', [AdherantController::class, 'soumettre'])->name('soumettre');
});
Route::get('/filieres/{universite}', [AdherantController::class, 'getFilieres'])->name('filieres.byUniversite');

//   ENFANT - Workflow multi-étapes
// ===============================z
Route::prefix('enfant')->name('enfant.')->group(function () {
    Route::get('/step1', [AdherantController::class, 'enfantStep1'])->name('step1');
    Route::post('/step1', [AdherantController::class, 'postEnfantStep1'])->name('post.step1');

    Route::get('/step2', [AdherantController::class, 'enfantStep2'])->name('step2');
    Route::post('/step2', [AdherantController::class, 'postEnfantStep2'])->name('post.step2');

    Route::get('/step3', [AdherantController::class, 'enfantStep3'])->name('step3');
    Route::post('/step3', [AdherantController::class, 'postEnfantStep3'])->name('post.step3');

    Route::get('/step4', [AdherantController::class, 'enfantStep4'])->name('step4');
    Route::post('/soumettre', [AdherantController::class, 'enfantSoumettre'])->name('soumettre');
});

// CONJOINT - Workflow multi-étapes
Route::prefix('conjoint')->name('conjoint.')->group(function () {
    Route::get('/step1', [AdherantController::class, 'conjointStep1'])->name('step1');
    Route::post('/step1', [AdherantController::class, 'postConjointStep1'])->name('post.step1');

    Route::get('/step2', [AdherantController::class, 'conjointStep2'])->name('step2');
    Route::post('/step2', [AdherantController::class, 'postConjointStep2'])->name('post.step2');

    Route::get('/step3', [AdherantController::class, 'conjointStep3'])->name('step3');
    Route::post('/step3', [AdherantController::class, 'postConjointStep3'])->name('post.step3');

    Route::get('/step4', [AdherantController::class, 'conjointStep4'])->name('step4');
    Route::post('/soumettre', [AdherantController::class, 'conjointSoumettre'])->name('soumettre');
});

/*===============================
   RÉABONNEMENT
 ===============================*/
Route::prefix('munaseb/reabonnement')->name('munaseb.reabonnement.')->group(function () {

    Route::get('step1', [ReabonnementController::class, 'step1'])->name('reabonnementStep1');
    Route::post('step1', [ReabonnementController::class, 'postStep1'])->name('postStep1');

    Route::get('step2', [ReabonnementController::class, 'step2'])->name('reabonnementStep2');
    Route::post('step2', [ReabonnementController::class, 'postStep2'])->name('postStep2');

    Route::get('step3', [ReabonnementController::class, 'step3'])->name('reabonnementStep3');
    Route::post('step3', [ReabonnementController::class, 'postStep3'])->name('postStep3');
});

// Formulaire de vérification
Route::get('/demande/verifier', [AdherantController::class, 'formVerifierDemande'])->name('demande.form_verifier');

// Vérification et affichage du statut
Route::post('/demande/verifier', [AdherantController::class, 'verifierDemande'])->name('demande.verifier');
Route::get('/carte/verification/{numero}', function ($numero) {
    return "CARTE VALIDE : " . $numero;
})->name('carte.verification');