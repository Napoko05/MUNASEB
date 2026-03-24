<aside class="directeur-sidebar">

    {{-- LOGO EN HAUT --}}
    <div class="sidebar-logo">
        <img src="{{ asset('assets/image/logo_cenou.png') }}" 
             alt="CENOU Logo" 
             class="logo-img">
    </div>

    {{-- NOM ET PRÉNOM DE L'UTILISATEUR CONNECTÉ --}}
    <h4 class="sidebar-title">
        {{ Auth::user()->prenom ?? '' }} {{ Auth::user()->nom ?? '' }}
    </h4>

    {{-- ACCUEIL --}}
    <a href="{{ route('directeur.dashboard') }}" class="sidebar-link mt-2">
        <i class="bi bi-house"></i> Accueil
    </a>

    {{-- ADHESION --}}
    <div class="sidebar-item">
        <a href="#" class="sidebar-link sidebar-toggle">
            <span><i class="bi bi-person-plus"></i> Demande adhésion</span>
            <i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="sidebar-dropdown">
            <a href="{{ route('directeur.cartes.a_creer') }}" class="sidebar-sublink">Adhésion en attente</a>
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
            <a href="#" class="sidebar-sublink">Créer</a>
            <a href="#" class="sidebar-sublink">Liste</a>
        </div>
    </div>

    <a href="{{ route('directeur.cartes.listecarte') }}" class="sidebar-link">
        <i class="bi bi-credit-card"></i> Liste cartes
    </a>

    <a href="{{ route('directeur.stats') }}" class="sidebar-link">
        <i class="bi bi-bar-chart"></i> Statistiques
    </a>

    {{-- DECONNEXION --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>

</aside>