@extends('layouts.app', ['hideNavbar' => true])

@section('content')

<div class="page-wrapper">
    {{-- MENU --}}
    <nav class="navbar navbar-expand-lg menu-dynamic shadow-sm">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard.etudiant') }}">
                <img src="{{ asset('theme/munaseb/img/logo1.jpg') }}" alt="Logo MUNASEB" class="menu-logo">
            </a>

            <!-- Burger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dynamicMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Liens -->
            <div class="collapse navbar-collapse" id="dynamicMenu">
                <ul class="navbar-nav mx-auto" style="display:flex; gap:25px; list-style:none; padding:0; align-items:center;">
                    <li class="nav-item"><a class="nav-link dynamic-link" href="{{ route('dashboard.etudiant') }}">Accueil</a></li>
                    
                    <!-- Vérifier ma demande -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dynamic-link" href="#" data-bs-toggle="dropdown">Vérifier ma demande</a>
                        <ul class="dropdown-menu dynamic-dropdown">
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('demande.form_verifier') }}">Adhésion</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="#">Remboursement</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="#">Réabonnement</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dynamic-link" href="#" data-bs-toggle="dropdown">Nouvelle adhésion</a>
                        <ul class="dropdown-menu dynamic-dropdown">
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('munaseb.adherant.adhesionstep1') }}">Étudiant</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('enfant.step1') }}">Enfant</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('conjoint.step1') }}">Conjoint(e)</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dynamic-link" href="#" data-bs-toggle="dropdown">Nouvelle demande</a>
                        <ul class="dropdown-menu dynamic-dropdown">
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('etudiant.adhesion.remboursement') }}">Demande remboursement</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('munaseb.reabonnement.reabonnementStep1') }}">Réabonnement</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link dynamic-link" href="">Téléchargement</a></li>
                    <li class="nav-item"><a class="nav-link dynamic-link" href="{{ route('etudiant.profile.edit') }}">Profil</a></li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="ms-auto">
                    @csrf
                    <button class="btn logout-btn">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- CONTENU CENTRAL --}}
    <main>
        {{-- CARTE DRAPEAU AVEC CONTOUR ROUGE --}}
        <section class="card border-danger mt-4 mx-auto" style="max-width: 900px;">
            <div class="card-header bg-danger text-white text-center fw-bold">
                Bienvenue à la MUNASEB
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('theme/munaseb/img/stock-photo0.jpg') }}" class="banner-img" alt="Drapeau Burkina Faso">
                <marquee behavior="scroll" direction="left" class="text-success fw-bold mt-3">
                    Bienvenue sur la plateforme E-MUNASEB – Vos droits, votre santé, notre engagement.
                </marquee>
            </div>
        </section>

        {{-- CARTE ROUGE : ÉTAPES D’ADHÉSION --}}
        <section class="card border-danger mt-5 mx-auto" style="max-width: 900px;">
            <div class="card-header bg-danger text-white text-center fw-bold">
                Étapes d’adhésion à la MUNASEB
            </div>
            <div class="card-body">
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Créer un compte étudiant sur la plateforme.</li>
                    <li class="list-group-item">Se connecter avec ses identifiants.</li>
                    <li class="list-group-item">Remplir le formulaire d’adhésion en ligne.</li>
                    <li class="list-group-item">Téléverser les pièces justificatives demandées.</li>
                    <li class="list-group-item">Soumettre la demande et suivre son traitement.</li>
                </ol>
            </div>
        </section>

        {{-- SLIDER --}}
        <section class="slider-section">
            <h2 style="text-align:center; color:#045f2e; margin-bottom:30px;">Découverte</h2>
            <div class="slider">
                <div class="slider-track">
                    <div class="slide"><img src="{{ asset('theme/munaseb/img/femme-medecin.jpg') }}" alt="Notoriété 1"></div>
                    <div class="slide"><img src="{{ asset('theme/munaseb/img/Docteur.png') }}" alt="Notoriété 2"></div>
                    <div class="slide"><img src="{{ asset('theme/munaseb/img/medecin.jpg') }}" alt="Notoriété 3"></div>
                </div>
            </div>
            <div class="slider-controls">
                <button class="slider-btn" onclick="prevSlide()">❮</button>
                <button class="slider-btn" onclick="nextSlide()">❯</button>
            </div>
        </section>

        {{-- INFORMATIONS GÉNÉRALES --}}
        <section class="general-info">
            <h2>À propos de la MUNASEB</h2>
            <p>La Mutuelle Nationale de Santé des Étudiants du Burkina Faso (MUNASEB) a pour mission de garantir la couverture sanitaire des étudiants, de faciliter l’accès aux soins, et d’accompagner les étudiants tout au long de leur parcours universitaire. Elle propose des services variés tels que les adhésions, les demandes de remboursement, le réabonnement, et la mise à disposition de documents officiels et attestations.</p>
        </section>

        {{-- FAQ --}}
        <section class="faq">
            <h2 style="text-align:center; color:#045f2e; margin-bottom:30px;">Questions fréquentes</h2>
            <div class="faq-container">
                <div class="faq-item faq-active">
                    <h3>Comment adhérer à la MUNASEB ?</h3>
                    <span>Adhérez en ligne en quelques étapes simples.</span>
                    <div class="faq-content">
                        <p>Créez votre compte, connectez-vous, remplissez le formulaire d'adhésion et téléversez vos pièces justificatives.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <h3>Comment soumettre sa demande de remboursement ?</h3>
                    <span>Soumettez vos factures et ordonnances en ligne.</span>
                    <div class="faq-content">
                        <p>Accédez à votre espace personnel, remplissez le formulaire de demande de remboursement, téléversez les justificatifs et soumettez.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <h3>Comment suivre le statut de sa demande ?</h3>
                    <span>Suivez l’état de vos demandes en ligne.</span>
                    <div class="faq-content">
                        <p>Connectez-vous à votre espace personnel, consultez la section “Mes demandes”, suivez le statut et recevez des notifications.</p>
                    </div>
                </div>
            </div>
        </section>
        
    </main>
</div>
@endsection
<script>
let currentIndex = 0;

function showSlide(index) {
    const track = document.querySelector('.slider-track');
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    if (index < 0) {
        currentIndex = totalSlides - 1;
    } else if (index >= totalSlides) {
        currentIndex = 0;
    } else {
        currentIndex = index;
    }

    const offset = -currentIndex * 100; // déplacement en %
    track.style.transform = `translateX(${offset}%)`;
}

function prevSlide() {
    showSlide(currentIndex - 1);
}

function nextSlide() {
    showSlide(currentIndex + 1);
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    showSlide(0);
});
</script>
