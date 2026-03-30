<aside class="regie-sidebar shadow-sm">

    {{-- LOGO --}}
    <div class="regie-logo">
        <img src="{{ asset('assets/image/cenou_logo.png') }}" alt="CENOU Logo" class="regie-logo-img">
    </div>

    {{-- Utilisateur --}}
    <h4 class="sidebar-title">
        <i class="bi bi-person-circle"></i>
        {{ Auth::user()->prenom ?? '' }} {{ Auth::user()->nom ?? '' }}
    </h4>

    {{-- Accueil --}}
    <a href="{{ route('regie.dashboard') }}"
       class="regie-link {{ request()->routeIs('regie.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i>
        <span>Accueil</span>
    </a>

    {{-- Sous-menu adhésions --}}
    <div class="regie-item">
        <a href="#" class="regie-link regie-toggle">
            <span>
                <i class="bi bi-hourglass-split"></i>
                Adhésions non traitées
            </span>
            <i class="bi bi-chevron-down regie-arrow"></i>
        </a>

        <div class="regie-dropdown">
            <a href="{{ route('regie.adherants.nonvalidees') }}"
               class="regie-sublink {{ request()->routeIs('regie.adherants.non_valide') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                Adhérents
            </a>

            <a href="#"
               class="regie-sublink {{ request()->routeIs('regie.enfants.non_valide') ? 'active' : '' }}">
                <i class="bi bi-emoji-smile"></i>
                Enfants
            </a>

            <a href="#"
               class="regie-sublink {{ request()->routeIs('regie.conjoints.non_valide') ? 'active' : '' }}">
                <i class="bi bi-heart"></i>
                Conjoints
            </a>
        </div>
    </div>

    {{-- Adhésions traitées --}}
    <a href="{{ route('regie.adherants.traitees') }}"
       class="regie-link {{ request()->routeIs('regie.adherants.traitees') ? 'active' : '' }}">
        <i class="bi bi-check-circle-fill"></i>
        <span>Adhésions traitées</span>
    </a>

    {{-- Statistiques --}}
    <a href="#" class="regie-link">
        <i class="bi bi-bar-chart-line-fill"></i>
        <span>Statistiques</span>
    </a>

    {{-- Déconnexion --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button class="btn regie-btn-logout w-100">
            <i class="bi bi-box-arrow-right"></i>
            <span>Déconnexion</span>
        </button>
    </form>

</aside>