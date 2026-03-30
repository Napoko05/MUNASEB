<nav class="munaseb-navbar">

    <div class="nav-container">

        {{-- LOGO --}}
        <a class="munaseb-brand" href="#">
            <img src="{{ asset('assets/image/cenou_logo.png') }}" alt="MUNASEB" class="navbar-logo">
            <span class="brand-text">MUNASEB</span>
        </a>

        {{-- TOGGLE MOBILE --}}
        <button class="menu-toggle" id="menuToggle">
            <i class="bi bi-list"></i>
        </button>

        {{-- MENU --}}
        <ul class="nav-menu" id="navMenu">

            <li>
                <a href="{{ route('dashboard.etudiant') }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Accueil</span>
                </a>
            </li>

            {{-- VERIFIER --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-search"></i>
                    <span>Vérifier</span>
                    <i class="bi bi-chevron-down arrow"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{ route('demande.verifier') }}"><i class="bi bi-person-check"></i> Adhésion</a></li>
                    <li><a href="#"><i class="bi bi-cash"></i> Remboursement</a></li>
                    <li><a href="#"><i class="bi bi-arrow-repeat"></i> Réabonnement</a></li>
                </ul>
            </li>

            {{-- ADHESION --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-person-plus"></i>
                    <span>Adhésion</span>
                    <i class="bi bi-chevron-down arrow"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{ route('munaseb.adherant.adhesionstep1') }}"><i class="bi bi-mortarboard"></i> Étudiant</a></li>
                    <li><a href="{{ route('enfant.step1') }}"><i class="bi bi-emoji-smile"></i> Enfant</a></li>
                    <li><a href="{{ route('conjoint.step1') }}"><i class="bi bi-heart"></i> Conjoint</a></li>
                </ul>
            </li>

            {{-- DEMANDE --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span>Demandes</span>
                    <i class="bi bi-chevron-down arrow"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{ route('etudiant.adhesion.renouvellement') }}"><i class="bi bi-arrow-repeat"></i> Réabonnement</a></li>
                    <li><a href="{{ route('etudiant.adhesion.remboursement') }}"><i class="bi bi-cash-stack"></i> Remboursement</a></li>
                </ul>
            </li>

            {{-- TELECHARGEMENT --}}
            <li>
                <a href="#">
                    <i class="bi bi-download"></i>
                    <span>Téléchargement</span>
                </a>
            </li>

            {{-- PROFIL --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil</span>
                    <i class="bi bi-chevron-down arrow"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="#"><i class="bi bi-key"></i> Mot de passe</a></li>
                    <li><a href="#"><i class="bi bi-image"></i> Photo</a></li>
                    <li><a href="#"><i class="bi bi-question-circle"></i> Aide</a></li>
                </ul>
            </li>

            {{-- DECONNEXION --}}
            <li class="logout-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </li>

        </ul>

    </div>

</nav>