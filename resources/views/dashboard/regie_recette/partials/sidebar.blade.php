{{-- Sidebar Régie Recette --}}
<div class="sidebar shadow-sm">
    <h4 class="fw-bold text-center py-3">💼 Régie Recette</h4>

    {{-- Accueil --}}
    <a href="{{ route('regie.dashboard') }}">🏠 Accueil</a>

    {{-- Adhésions --}}
    <a data-bs-toggle="collapse" href="#adhesionsSubmenu" role="button" aria-expanded="false" aria-controls="adhesionsSubmenu">
        🟢 Adhésions non traitées
    </a>
    <div class="collapse submenu" id="adhesionsSubmenu">
        <a href="{{ route('regie.adherants.non_valide') }}">➕ Adhérents</a>
        <a href="{{ route('regie.enfants.non_valide') }}">👶 Enfants</a>
        <a href="{{ route('regie.conjoints.non_valide') }}">💑 Conjoints</a>
    </div>

    <a href="#">🟡 Adhésions traitées</a>

    {{-- Cartes --}}
    <a data-bs-toggle="collapse" href="#cartesSubmenu" role="button" aria-expanded="false" aria-controls="cartesSubmenu">
        💳 Cartes
    </a>
    <div class="collapse submenu" id="cartesSubmenu">
        <a href="#">🟡 Cartes non validées</a>
        <a href="#">🟢 Cartes validées</a>
    </div>

    {{-- Statistiques --}}
    <a href="#">📊 Statistiques</a>

    {{-- Déconnexion --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">🔴 Déconnexion</button>
    </form>
</div>

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
    padding-top: 70px; /* ajuster si tu as un header fixe */
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
    background: rgba(255, 255, 255, 0.2);
}
.sidebar .submenu a {
    padding-left: 40px;
    font-size: 0.95rem;
}
</style>
