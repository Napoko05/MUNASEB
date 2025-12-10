@extends('layouts.app', ['hideNavbar' => true])

@section('content')
<style>
    /* =========================
       RESET GLOBAL
    ======================== */
    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e0f2f1, #ffffff);
    }

    * {
        box-sizing: border-box;
    }

    a {
        text-decoration: none;
    }

    .page-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* =========================
       MENU
    ======================== */
    .menu-dynamic {
        width: 100%;
        padding: 10px 30px;
        background: linear-gradient(90deg, #0b8a43, #067a3b, #045f2e);
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.15);
    }

    .menu-logo {
        height: 58px;
        transition: transform 0.3s ease;
    }

    .menu-logo:hover {
        transform: scale(1.08);
    }

    .dynamic-link {
        color: #fff !important;
        font-weight: 600;
        font-size: 16px;
        position: relative;
        padding: 12px 10px;
        transition: color 0.3s ease;
    }

    .dynamic-link::after {
        content: "";
        position: absolute;
        bottom: 4px;
        left: 50%;
        width: 0%;
        height: 2px;
        background: #ffeb3b;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .dynamic-link:hover::after {
        width: 60%;
    }

    .dynamic-link:hover {
        color: #ffe600 !important;
    }

    .dynamic-dropdown {
        background: #0c6c36;
        border-radius: 0;
        overflow: hidden;
    }

    .dynamic-drop-item {
        color: #fff !important;
        padding: 10px 20px;
    }

    .dynamic-drop-item:hover {
        background: rgba(255, 255, 255, 0.2) !important;
    }

    .logout-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ff4a4a;
        color: #fff;
        border: none;
        padding: 7px 15px;
        border-radius: 4px;
        font-weight: bold;
    }

    .logout-btn:hover {
        background: #cc0000;
    }

    /* =========================
       HERO
    ======================== */
    .hero {
        background: url('{{ asset("theme/munaseb/img/stock-photo0.jpg") }}') no-repeat center center;
        background-size: cover;
        color: #ffffff;
        text-align: center;
        padding: 100px 20px;
        position: relative;
    }

    .hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .hero h1,
    .hero p,
    .hero .btn-hero,
    .dropdown-hero {
        position: relative;
        z-index: 2;
    }

    .hero h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        max-width: 700px;
        margin: auto;
    }

    .btn-hero {
        background: #045f2e;
        color: #fff;
        font-weight: bold;
        padding: 12px 28px;
        border-radius: 6px;
        margin: 5px;
        display: inline-block;
        transition: transform 0.3s, background 0.3s, color 0.3s;
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        background: #ffeb3b;
        color: #045f2e;
    }

    /* ===== DROPDOWN HERO ===== */
    .dropdown-hero {
        position: relative;
        display: inline-block;
        margin-top: 20px;
    }

    .dropdown-btn {
        background: #045f2e;
        color: #fff;
        font-weight: bold;
        padding: 12px 28px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: transform 0.3s, background 0.3s, color 0.3s;
    }

    .dropdown-btn:hover {
        transform: translateY(-3px);
        background: #ffeb3b;
        color: #045f2e;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background: rgba(0, 0, 0, 0.8);
        min-width: 200px;
        border-radius: 6px;
        z-index: 3;
    }

    .dropdown-content a {
        display: block;
        padding: 10px;
        color: #fff;
        text-decoration: none;
        transition: background 0.2s;
    }

    .dropdown-content a:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* =========================
       FAQ CARTES DÉROULANTES
    ======================== */
    .faq-container {
        max-width: 900px;
        margin: auto;
    }

    .faq-item {
        background: hsla(0, 11%, 97%, 1.00);
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .faq-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .faq-item h3 {
        padding: 15px 20px;
        margin: 0;
        font-size: 1.1rem;
    }

    .faq-item span {
        display: block;
        padding: 0 20px 15px 20px;
        font-size: 0.95rem;
        color: #555;
    }

    .faq-content {
        max-height: 0;
        overflow: hidden;
        padding: 0 20px;
        transition: max-height 0.3s ease, padding 0.3s ease;
        color: #333;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .faq-item.faq-active .faq-content {
        max-height: 500px;
        padding: 15px 20px;
    }

    /* =========================
       SLIDER
    ======================== */
    .slider {
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .slider-track {
        display: flex;
        transition: transform 0.5s ease;
    }

    .slide {
        min-width: 100%;
        transition: transform 0.5s;
    }

    .slide img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
    }

    .slider-controls {
        text-align: center;
        margin-top: 20px;
    }

    .slider-btn {
        background: #045f2e;
        color: #fff;
        border: none;
        padding: 8px 16px;
        margin: 0 5px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    .slider-btn:hover {
        background: #067a3b;
    }

    /* =========================
       INFORMATIONS GÉNÉRALES
    ======================== */
    .general-info {
        background: #ffffff;
        padding: 80px 20px;
        text-align: center;
    }

    .general-info h2 {
        color: #045f2e;
        margin-bottom: 30px;
        font-size: 2rem;
    }

    .general-info p {
        max-width: 800px;
        margin: 0 auto;
        color: #333;
        line-height: 1.6;
    }

    /* =========================
       FOOTER
    ======================== */
    /* =========================
   LAYOUT GLOBAL
========================= */
    html,
    body {
        height: 100%;
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* MAIN PREND TOUT L’ESPACE */
    .page-wrapper main {
        flex: 1;
    }

    /* =========================
   FOOTER
========================= */
    .footer-bf {
        width: 100%;
        background-color: #0a8f2f;
        color: #ffffff;
        padding: 25px 20px;
        font-size: 14px;
    }

    /* Liens */
    .footer-bf a {
        color: #ffffff;
        text-decoration: none;
    }

    .footer-bf a:hover {
        text-decoration: underline;
    }

    .footer-bf p {
        margin-bottom: 5px;
    }
</style>

<div class="page-wrapper">
    {{-- MENU --}}
    <nav class="navbar navbar-expand-lg menu-dynamic">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard.etudiant') }}">
                <img src="{{ asset('theme/munaseb/img/logo1.jpg') }}" alt="Logo MUNASEB" class="menu-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dynamicMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dynamicMenu">
                <ul class="navbar-nav mx-auto" style="display:flex; gap:25px; list-style:none; padding:0; align-items:center;">
                    <li class="nav-item"><a class="nav-link dynamic-link" href="{{ route('dashboard.etudiant') }}">Accueil</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dynamic-link" href="#" data-bs-toggle="dropdown">Nouvelle adhésion</a>
                        <ul class="dropdown-menu dynamic-dropdown">
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('munaseb.adherant.adhesionstep1') }}">Étudiant</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('munaseb.adherant.add_enfantstep1') }}">Enfant</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('munaseb.adherant.add_conjointstep1') }}">Conjoint(e)</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dynamic-link" href="#" data-bs-toggle="dropdown">Nouvelle demande</a>
                        <ul class="dropdown-menu dynamic-dropdown">
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('etudiant.adhesion.remboursement') }}">Demande remboursement</a></li>
                            <li><a class="dropdown-item dynamic-drop-item" href="{{ route('munaseb.reabonnement.reabonnementStep1') }}">Réabonnement</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link dynamic-link" href="#">Téléchargement</a></li>
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
        {{-- HERO --}}
        <section class="hero">
            <h1>Bienvenue à la E-munaseb</h1>
            <p>La Mutuelle Nationale de Santé des Étudiants du Burkina Faso – Vos droits, votre santé, notre engagement.</p>
            <div class="hero-buttons">
                <div class="dropdown-hero">
                    <button class="dropdown-btn">Vérifier ma demande ▾</button>
                    <div class="dropdown-content">
                        <a href="{{ route('munaseb.adherant.adhesionstep1') }}">Adhésion</a>
                        <a href="{{ route('etudiant.adhesion.remboursement') }}">Remboursement</a>
                        <a href="{{ route('munaseb.reabonnement.reabonnementStep1') }}">Réabonnement</a>
                    </div>
                </div>
                <a href="{{ route('etudiant.profile.edit') }}" class="btn-hero">Mon profil</a>
            </div>
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

        {{-- SLIDER --}}
        <section class="slider-section">
            <h2 style="text-align:center; color:#045f2e; margin-bottom:30px;">Découvrez notre notoriété</h2>
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
    </main>

    {{-- FOOTER --}}
    <footer class="footer-bf">
        <div class="container-fluid">
            <div class="row text-center text-md-start">

                <!-- Bloc gauche -->
                <div class="col-md-4 mb-3">
                    <p class="fw-bold mb-1">
                        LA MUNASEB est un établissement public
                    </p>
                    <p class="mb-0">
                        chargé de la gestion de la couverture
                        sanitaire des étudiants au Burkina Faso.
                    </p>
                    <p class="mt-2 mb-0">© 2025 CENOU</p>
                </div>

                <!-- Bloc centre -->
                <div class="col-md-4 mb-3 text-center">
                    <p class="fw-bold mb-2">Contacts</p>
                    <p class="mb-1">Tel : <strong>(+226)</strong></p>
                    <p class="mb-1">
                        Email :
                        <a href="mailto:cenou.gov.bf">cenou.gov.bf</a>
                    </p>
                    <p class="mb-0">
                        Adresse : 01 BP 526 Ouagadougou BURKINA FASO
                    </p>
                </div>

                <!-- Bloc droite -->
                <div class="col-md-4 mb-3 text-md-end">
                    <p class="fw-bold mb-0">
                        Produit par la Direction des Systèmes
                    </p>
                    <p class="mb-0">
                        d’Informatique (DSI de CENOU)
                    </p>
                </div>

            </div>
        </div>
    </footer>


</div>

{{-- JS --}}
<script>
    // Slider
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        const track = document.querySelector('.slider-track');
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        currentSlide = index;
        track.style.transform = `translateX(-${100*currentSlide}%)`;
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }
    setInterval(nextSlide, 5000);

    // FAQ accordéon
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('faq-active');
            faqItems.forEach(other => {
                if (other !== item) other.classList.remove('faq-active');
            });
        });
    });

    // Dropdown Hero
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownContent = document.querySelector('.dropdown-content');

    dropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', () => {
        dropdownContent.style.display = 'none';
    });
</script>
@endsection