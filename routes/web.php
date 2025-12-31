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
use App\Http\Controllers\Dashboard\LiquidationController;
use App\Http\Controllers\Dashboard\TresorierController;
use App\Http\Controllers\Dashboard\AdhesionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\munaseb\AdherantController;
use App\Http\Controllers\munaseb\ReabonnementController;
use App\Http\Controllers\Dashboard\CarteController;


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
    Route::get('/dashboard/regie_recette', [RegieController::class, 'index'])->name('dashboard.regie');
});

Route::middleware(['auth', 'role:directeur'])
    ->prefix('directeur')
    ->name('directeur.')
    ->group(function () {

        // Tableau de bord
        Route::get('/', [DirecteurController::class, 'index'])
            ->name('dashboard');

        // ======================
        // ADHÉSIONS / DOSSIERS
        // ======================

        // Liste des adhésions validées par la régie (à traiter par le directeur)
        Route::get('/adhesion/traitees', [DirecteurController::class, 'adhesionsValidees'])
            ->name('adhesion.traites');

        // Détail d’un dossier soumis par un adhérent
        Route::get('/adhesion/{id}', [DirecteurController::class, 'detailProfil'])
            ->name('adhesion.detail');

        // ======================
        // CARTES
        // ======================

        // Liste des adhérents validés mais sans carte (à créer)
        Route::get('/cartes/a-creer', [DirecteurController::class, 'cartesNonTraite'])
            ->name('cartes.a_creer');

        // Création automatique d’une carte (POST)
        Route::post('/adherant/{adherant}/creer-carte', [CarteController::class, 'creer'])
            ->name('cartes.creer');

        // Liste des cartes déjà créées
        Route::get('/cartes', [CarteController::class, 'listeCartes'])
            ->name('cartes.listecarte');

        // Aperçu carte (HTML / PDF)
        Route::get('/cartes/{carte}', [DirecteurController::class, 'voirCarte'])
            ->name('cartes.show');


        // Rejeter un adhérent avec motif
        Route::post('/adherant/{id}/rejeter', [DirecteurController::class, 'rejeterAdherant'])
            ->name('adherant.rejeter');

        // ======================
        // DOCUMENTS
        // ======================

        Route::get('/dossier/{id}/document', [DirecteurController::class, 'voirDocument'])
            ->name('dossier.voirDocument');

        Route::get('/directeur/cartes/{id}', [DirecteurController::class, 'voirCarte'])
            ->name('cartes.show')
            ->middleware(['auth', 'role:directeur']);

        // ======================
        // STATISTIQUES
        // ======================

        Route::get('/stats', [DirecteurController::class, 'stats'])
            ->name('stats');
    });
     // Télécharger la carte au format PDF

        Route::get('/carte/{id}/telecharger', [CarteController::class, 'telecharger'])
            ->name('carte.telecharger');


// Routes Régie de recette

Route::prefix('regie')
    ->name('regie.')
    ->middleware('auth')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [RegieController::class, 'dashboard'])->name('dashboard');

        /* =========================
       ADHÉRANTS
    ========================= */
        Route::get('/adherants/non-valide', [RegieController::class, 'adherantsNonValides'])
            ->name('adherants.non_valide');

        Route::get('/adherant/{id}/detail', [RegieController::class, 'detailAdherant'])
            ->name('adherant.detail');

        Route::post('/adherant/{id}/valider', [RegieController::class, 'validerAdherant'])
            ->name('adherant.valider');

        Route::post('/adherant/{id}/rejeter', [RegieController::class, 'rejeterAdherant'])
            ->name('adherant.rejeter');

        Route::get('/dossier/{id}/document', [RegieController::class, 'voirDocument'])
            ->name('dossier.voirDocument');

        /* =========================
       ENFANTS
    ======================= */
        Route::get('/enfants/non-valide', [RegieController::class, 'enfantsNonValides'])
            ->name('enfants.non_valide');

        Route::get('/enfant/{id}/detail', [RegieController::class, 'detailEnfant'])
            ->name('enfant.detail');

        Route::post('/enfant/{id}/valider', [RegieController::class, 'validerEnfant'])
            ->name('enfant.valider');

        Route::post('/enfant/{id}/rejeter', [RegieController::class, 'rejeterEnfant'])
            ->name('enfant.rejeter');

        /* =========================
       CONJOINTS
    ========================= */
        Route::get('/conjoints/non-valide', [RegieController::class, 'conjointsNonValides'])
            ->name('conjoints.non_valide');

        Route::get('/conjoint/{id}/detail', [RegieController::class, 'detailConjoint'])
            ->name('conjoint.detail');

        Route::post('/conjoint/{id}/valider', [RegieController::class, 'validerConjoint'])
            ->name('conjoint.valider');

        Route::post('/conjoint/{id}/rejeter', [RegieController::class, 'rejeterConjoint'])
            ->name('conjoint.rejeter');

        /* =========================
       ADHÉSIONS TRAITÉES
    ========================= */
        Route::get('/adhesions/traitees', [RegieController::class, 'adhesionsTraitees'])
            ->name('adherants.traitees');

        Route::get('/adherant/{id}/modifier', [RegieController::class, 'modifierAdherant'])
            ->name('adherant.modifier');
    });

// Routes Liquidation
Route::middleware(['auth', 'role:liquidation_production'])->group(function () {
    Route::get('/adhesions/en-cours', [AdhesionController::class, 'enCours'])->name('adhesions.en_cours');
});

// Routes Trésorier
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

// Processus d’adhésion multi-étapes (Parent, Enfant, Conjoint)
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
// ← FIN du groupe adhérant
// ===============================
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


// ← FIN du groupe adhérant


// ===============================
//   RÉABONNEMENT (GROUPE DÉTACHÉ)
// ===============================
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
