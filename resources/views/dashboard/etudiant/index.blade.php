@extends('layouts.app_adherent')

@section('title', 'Dashboard Étudiant')

@section('content')

{{-- BIENVENUE --}}
<section class="welcome-section text-center my-5">
    <h1 class="fw-bold text-primary">
        Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
    </h1>
    <p class="text-muted">
        Voici un aperçu de vos demandes
    </p>
</section>

{{-- CARTES --}}
<div class="row dashboard-row g-4">

    {{-- Carte : Demande en attente --}}
    <div class="col-card">
        <div class="dashboard-card">
            <div class="card-body">
                <h6 class="card-title">Demande en attente</h6>
                <p class="card-text">2</p>
                <span class="badge badge-info">En attente</span>
            </div>
        </div>
    </div>

    {{-- Carte : Demande approuvée --}}
    <div class="col-card">
        <div class="dashboard-card">
            <div class="card-body">
                <h6 class="card-title">Demande approuvée</h6>
                <p class="card-text">#</p>
                <span class="badge badge-success">Validées</span>
            </div>
        </div>
    </div>

    {{-- Carte : Demande rejetée --}}
    <div class="col-card">
        <div class="dashboard-card">
            <div class="card-body">
                <h6 class="card-title">Demande rejetée</h6>
                <p class="card-text">#</p>
                <span class="badge badge-danger">Refusées</span>
            </div>
        </div>
    </div>

    {{-- Carte : Solde congé --}}
    <div class="col-card">
        <div class="dashboard-card">
            <div class="card-body">
                <h6 class="card-title">Solde congé</h6>
                <p class="card-text">#</p>
                <span class="badge badge-info">Solde congé</span>
            </div>
        </div>
    </div>

</div> {{-- row dashboard-row --}}

{{-- ÉTAPES INTERACTIVES --}}
<section class="my-5 mx-auto" style="max-width: 900px;">
    <h3 class="mb-4 text-center fw-bold">Étapes d’adhésion à la MUNASEB</h3>

    <div class="accordion" id="inscriptionSteps">

        {{-- Étape 1 --}}
        <div class="accordion-item mb-3 shadow-sm">
            <h2 class="accordion-header" id="step1Header">
                <button class="accordion-button d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#step1" aria-expanded="true" aria-controls="step1">
                    <span class="display-4 text-primary me-3">1</span>
                    Créer un compte étudiant
                </button>
            </h2>
            <div id="step1" class="accordion-collapse collapse show" aria-labelledby="step1Header" data-bs-parent="#inscriptionSteps">
                <div class="accordion-body">
                    Pour commencer, rendez-vous sur le site de la MUNASEB et cliquez sur "Créer un compte".<br>
                    Remplissez vos informations personnelles correctement.<br>
                    Vérifiez que votre adresse e-mail est valide pour recevoir les notifications.<br>
                    Choisissez un mot de passe sécurisé.<br>
                    Confirmez votre inscription via le lien envoyé par e-mail.
                </div>
            </div>
        </div>

        {{-- Étape 2 --}}
        <div class="accordion-item mb-3 shadow-sm">
            <h2 class="accordion-header" id="step2Header">
                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#step2" aria-expanded="false" aria-controls="step2">
                    <span class="display-4 text-primary me-3">2</span>
                    Se connecter
                </button>
            </h2>
            <div id="step2" class="accordion-collapse collapse" aria-labelledby="step2Header" data-bs-parent="#inscriptionSteps">
                <div class="accordion-body">
                    Après la création de votre compte, allez sur la page de connexion.<br>
                    Entrez votre adresse e-mail et votre mot de passe.<br>
                    Cochez "Se souvenir de moi" si vous utilisez votre appareil personnel.<br>
                    Cliquez sur "Connexion" pour accéder à votre tableau de bord.<br>
                    En cas d’oubli, utilisez la fonction "Mot de passe oublié".
                </div>
            </div>
        </div>

        {{-- Étape 3 --}}
        <div class="accordion-item mb-3 shadow-sm">
            <h2 class="accordion-header" id="step3Header">
                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#step3" aria-expanded="false" aria-controls="step3">
                    <span class="display-4 text-primary me-3">3</span>
                    Remplir le formulaire
                </button>
            </h2>
            <div id="step3" class="accordion-collapse collapse" aria-labelledby="step3Header" data-bs-parent="#inscriptionSteps">
                <div class="accordion-body">
                    Accédez à la section "Formulaire d’inscription".<br>
                    Complétez toutes les informations demandées (études, coordonnées, etc.).<br>
                    Vérifiez soigneusement les champs avant de soumettre.<br>
                    Les champs marqués d’une étoile sont obligatoires.<br>
                    Cliquez sur "Enregistrer" pour sauvegarder votre formulaire.
                </div>
            </div>
        </div>

        {{-- Étape 4 --}}
        <div class="accordion-item mb-3 shadow-sm">
            <h2 class="accordion-header" id="step4Header">
                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#step4" aria-expanded="false" aria-controls="step4">
                    <span class="display-4 text-primary me-3">4</span>
                    Téléverser les pièces
                </button>
            </h2>
            <div id="step4" class="accordion-collapse collapse" aria-labelledby="step4Header" data-bs-parent="#inscriptionSteps">
                <div class="accordion-body">
                    Préparez vos documents en format PDF ou image.<br>
                    Cliquez sur "Téléverser" pour chaque document requis.<br>
                    Assurez-vous que chaque fichier respecte la taille maximale autorisée.<br>
                    Vérifiez que vos documents sont lisibles et complets.<br>
                    Une fois tous les fichiers téléchargés, cliquez sur "Soumettre".
                </div>
            </div>
        </div>

        {{-- Étape 5 --}}
        <div class="accordion-item mb-3 shadow-sm">
            <h2 class="accordion-header" id="step5Header">
                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#step5" aria-expanded="false" aria-controls="step5">
                    <span class="display-4 text-primary me-3">5</span>
                    Suivre la demande
                </button>
            </h2>
            <div id="step5" class="accordion-collapse collapse" aria-labelledby="step5Header" data-bs-parent="#inscriptionSteps">
                <div class="accordion-body">
                    Après la soumission, accédez à votre tableau de bord.<br>
                    Vérifiez l’état de chaque document et demande.<br>
                    Recevez des notifications par e-mail sur l’avancement.<br>
                    Contactez le support en cas de problème ou de retard.<br>
                    Une fois approuvé, vous recevrez votre confirmation officielle.
                </div>
            </div>
        </div>

    </div>
</section>

{{-- INFOS --}}
<section class="general-info">
    <h2>À propos de la MUNASEB</h2>
    <p>La MUNASEB garantit la couverture sanitaire des étudiants du Burkina Faso.</p>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const accordions = document.querySelectorAll('.accordion-button');

    accordions.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const targetId = btn.getAttribute('data-bs-target');
            const content = document.querySelector(targetId);

            // Toggle show/hide manuellement pour plus de flexibilité
            if (content.classList.contains('show')) {
                content.classList.remove('show');
            } else {
                // Pour permettre l'ouverture de plusieurs cartes, on ne ferme pas les autres
                content.classList.add('show');
            }
        });
    });
});
</script>
@endsection