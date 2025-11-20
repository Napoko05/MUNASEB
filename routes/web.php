<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Dashboard\EtudiantController;
use App\Http\Controllers\Dashboard\DirecteurController;
use App\Http\Controllers\Dashboard\RegieRecetteController;
use App\Http\Controllers\Dashboard\LiquidationController;
use App\Http\Controllers\Dashboard\TresorierController;
use App\Http\Controllers\Dashboard\AdhesionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\munaseb\AdherantController;
use App\Http\Controllers\munaseb\ReabonnementController;

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
    Route::get('/dashboard/regie_recette', [RegieRecetteController::class, 'index'])->name('dashboard.regie');
    
});

// Routes Directeur
Route::middleware(['auth', 'role:directeur'])
    ->prefix('dashboard/directeur')
    ->name('directeur.')
    ->group(function () {
        Route::get('/', [DirecteurController::class, 'index'])->name('dashboard');
        Route::get('/carte/en-cours', [DirecteurController::class, 'CarteNonValide'])->name('carte.en_cours');
        Route::get('/adhesion/traitees', [DirecteurController::class, 'adhesionsTraitees'])->name('adhesion.traites');
        Route::get('/cartes', [DirecteurController::class, 'cartesValides'])->name('cartes');
        Route::get('/stats', [DirecteurController::class, 'stats'])->name('stats');
        Route::get('/adhesion/{id}', [DirecteurController::class, 'detailCartes'])->name('adhesion.detail');
        Route::post('/adhesion/traiter/{id}', [DirecteurController::class, 'traiter'])->name('cartes.traiter');
    });

// Routes Régie Recette
Route::middleware(['auth', 'role:regie_recette'])
    ->prefix('dashboard/regie_recette')
    ->name('regie.')
    ->group(function () {
        Route::get('/', [RegieRecetteController::class, 'index'])->name('dashboard');
        Route::get('/reabonnement/en-cours', [RegieRecetteController::class, 'reabonnementEnCours'])->name('reabonnement.en_cours');
        Route::get('/adhesion/traitees', [RegieRecetteController::class, 'adhesionsTraitees'])->name('adhesion.traites');
        Route::get('/cartes', [RegieRecetteController::class, 'cartes'])->name('cartes');
        Route::get('/stats', [RegieRecetteController::class, 'stats'])->name('stats');
        Route::get('/adhesion/{id}', [RegieRecetteController::class, 'detailAdhesion'])->name('adhesion.detail');
        Route::post('/adhesion/traiter/{id}', [RegieRecetteController::class, 'traiter'])->name('adhesion.traiter');
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

    // Parent
    Route::prefix('parent')->group(function () {
        Route::get('step1', [AdherantController::class, 'step1'])->name('adhesionstep1');
        Route::post('step1', [AdherantController::class, 'postParentStep1'])->name('postParentStep1');

        Route::get('step2', [AdherantController::class, 'step2'])->name('adhesionstep2');
        Route::post('step2', [AdherantController::class, 'postParentStep2'])->name('postParentStep2');

        Route::get('step3', [AdherantController::class, 'step3'])->name('adhesionstep3');
        Route::post('step3', [AdherantController::class, 'postParentStep3'])->name('postParentStep3');
    });

    // Enfant
    Route::prefix('enfant')->group(function () {
        Route::get('step01', [AdherantController::class, 'showEnfantStep1'])->name('add_enfantstep1');
        Route::post('step01', [AdherantController::class, 'postEnfantStep1'])->name('postEnfantStep1');

        Route::get('step02', [AdherantController::class, 'showEnfantStep2'])->name('add_enfantstep2');
        Route::post('step02', [AdherantController::class, 'postEnfantStep2'])->name('postEnfantStep2');

        Route::get('step03', [AdherantController::class, 'showEnfantStep3'])->name('add_enfantstep3');
        Route::post('step03', [AdherantController::class, 'postEnfantStep3'])->name('postEnfantStep3');
    });

    // Conjoint
    Route::prefix('conjoint')->group(function () {
        Route::get('stepc1', [AdherantController::class, 'showConjointStep1'])->name('add_conjointstep1');
        Route::post('stepc1', [AdherantController::class, 'postConjointStep1'])->name('postConjointStep1');

        Route::get('stepc2', [AdherantController::class, 'showConjointStep2'])->name('add_conjointstep2');
        Route::post('stepc2', [AdherantController::class, 'postConjointStep2'])->name('postConjointStep2');

        Route::get('stepc3', [AdherantController::class, 'showConjointStep3'])->name('add_conjointstep3');
        Route::post('stepc3', [AdherantController::class, 'postConjointStep3'])->name('postConjointStep3');
    });

}); // ← FIN du groupe adhérant


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

