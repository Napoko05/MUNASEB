<aside class="liquidation-sidebar">

    {{-- LOGO --}}
    <div class="sidebar-logo text-center mb-4">
        <img src="{{ asset('assets/image/cenou_logo.png') }}" alt="CENOU Logo" class="logo-img">
    </div>

    {{-- USER --}}
    <h4 class="sidebar-title">
        {{ Auth::user()->prenom ?? '' }} {{ Auth::user()->nom ?? '' }}
    </h4>

    <a href="{{ route('liquidation.dashboard') }}" class="sidebar-link mt-2">
        <i class="bi bi-house"></i> Accueil
    </a>

    {{-- ADHESION --}}
    <div class="sidebar-item">
        <a href="#" class="sidebar-link sidebar-toggle">
            <span><i class="bi bi-person-plus"></i> Demande adhésion</span>
            <i class="bi bi-chevron-down arrow"></i>
        </a>

        <div class="sidebar-dropdown">
            <a href="{{ route('liquidation.dashboard') }}" class="sidebar-sublink">
                Adhésion en attente
            </a>
             <a href="{{ route('liquidation.cartes.liste') }}" class="sidebar-sublink">
                Adhesions traites
            </a>
            <a href="#" class="sidebar-sublink">Réabonnement en attente</a>
            
        </div>
    </div>

    {{-- REMBOURSEMENT --}}
    <div class="sidebar-item">
        <a href="#" class="sidebar-link sidebar-toggle">
            <span><i class="bi bi-cash"></i> Remboursement</span>
            <i class="bi bi-chevron-down arrow"></i>
        </a>

        <div class="sidebar-dropdown">
            <a href="#" class="sidebar-sublink">En attente</a>
            <a href="#" class="sidebar-sublink">Traités</a>
        </div>
    </div>

    {{-- AUTORISATION --}}
    <div class="sidebar-item">
        <a href="#" class="sidebar-link sidebar-toggle">
            <span><i class="bi bi-shield-check"></i> Autorisation</span>
            <i class="bi bi-chevron-down arrow"></i>
        </a>

        <div class="sidebar-dropdown">
            <a href="#" class="sidebar-sublink">Créer carte</a>
            <a href="{{ route('liquidation.cartes.liste') }}" class="sidebar-sublink">Liste carte</a>
        </div>
    </div>

    <a href="{{ route('liquidation.stats') }}" class="sidebar-link">
        <i class="bi bi-bar-chart"></i> Statistiques
    </a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>

</aside>