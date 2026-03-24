<nav class="munaseb-navbar">

    <div class="nav-container">

        {{-- LOGO --}}
        <div class="nav-logo">
            <a href="{{ route('dashboard.etudiant') }}">
                MUNASEB
            </a>
        </div>

        {{-- MENU --}}
        <ul class="nav-menu">

            {{-- ACCUEIL --}}
            <li>
                <a href="{{ route('dashboard.etudiant') }}">
                    Accueil
                </a>
            </li>

            {{-- VERIFIER DEMANDE --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    Vérifier ma demande
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a class="dropdown-item" href="{{ route('demande.verifier') }}">
                            Adhésion
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            Remboursement
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('demande.verifier') }}">
                            Réabonnement adhésion
                        </a>
                    </li>

                </ul>
            </li>


            {{-- NOUVELLE ADHESION --}}
            <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    Nouvelle adhésion
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a class="dropdown-item"
                            href="{{ route('munaseb.adherant.adhesionstep1') }}">
                            Étudiant
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="{{ route('enfant.step1') }}">
                            Enfant
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="{{ route('conjoint.step1') }}">
                            Conjoint
                        </a>
                    </li>

                </ul>

            </li>


            {{-- NOUVELLE DEMANDE --}}
            <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    Nouvelle demande
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a class="dropdown-item"
                            href="{{ route('etudiant.adhesion.renouvellement') }}">
                            Réabonnement
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="{{ route('etudiant.adhesion.remboursement') }}">
                            Remboursement
                        </a>
                    </li>

                </ul>

            </li>


            {{-- TELECHARGEMENT --}}
            <li>

                <a href="#">
                    Téléchargement
                </a>

            </li>


            {{-- PROFIL --}}
            <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    Profil
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a class="dropdown-item"
                            href="#">
                            Modifier mot de passe
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="#">
                            Modifier photo
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="#">
                            Aide
                        </a>
                    </li>

                </ul>

            </li>


            {{-- DECONNEXION --}}
            <li>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn">
                        Déconnexion
                    </button>
                </form>

            </li>

        </ul>

    </div>

</nav>