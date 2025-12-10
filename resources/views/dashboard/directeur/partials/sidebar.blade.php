<div class="sidebar shadow-sm">
    <h4 class="fw-bold">Directeur de la MUNASEB</h4>

    <!-- Accueil -->
    <a href="{{ route('directeur.dashboard') }}">Accueil</a>

    <!-- Agents -->
    <a href="#">Agents</a>

    <!-- Cartes -->
    <a data-bs-toggle="collapse"
        href="#cartesSubmenu"
        role="button"
        aria-expanded="false"
        aria-controls="cartesSubmenu">
        Cartes
    </a>
    <div class="collapse submenu" id="cartesSubmenu">
        <a href="{{ route('directeur.cartes.traiter') }}" class="btn btn-sm btn-primary">
            Créer sa carte
        </a>
        <a href="#">Liste Cartes</a>
    </div>

    <!-- Statistiques -->
    <a href="#">Statistiques</a>

    <!-- Déconnexion -->
    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>

    {{-- Style optionnel si sidebar fixe --}}
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: #0d6efd;
            color: white;
            padding-top: 70px;
            /* ajuster si tu as un header fixe */
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: rgba(252, 251, 255, 0.2);
        }

        .sidebar .submenu a {
            padding-left: 40px;
            font-size: 0.95rem;
        }
    </style>
</div>