@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- MENU HORIZONTAL -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow rounded-3 mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#">💼 Régie Recette</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarRegie" aria-controls="navbarRegie" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarRegie">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- Accueil --}}
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('regie.dashboard') }}">
                            🏠 Accueil
                        </a>
                    </li>
                    <!-- Adhésions non traitées -->
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="adhesionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            🟢 Adhésions non traitées
                        </a>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" href="#">➕ Nouvelle adhésion</a></li>
                            <li><a class="dropdown-item" href="#">🔁 Réabonnement</a></li>
                        </ul>
                    </li>

                    <!-- Autres liens -->
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#">🟡 Adhésions traitées</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#">💳 Cartes</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#">📊 Statistiques</a>
                    </li>
                </ul>

                <!-- Déconnexion -->
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button class="btn btn-outline-light btn-sm fw-semibold">🔴 Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CONTENU PRINCIPAL -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-gradient text-white" style="background: linear-gradient(90deg, #007bff, #6610f2);">
            <h4 class="mb-0 fw-bold">{{ $titre ?? '📋 Tableau de bord' }}</h4>
        </div>

        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dossiers as $dossier)
                        <tr>
                            <td>{{ $dossier->profil->nom }}</td>
                            <td>{{ $dossier->profil->prenom }}</td>
                            <td>
                                @if($dossier->statut === 'en_attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                                @elseif($dossier->statut === 'valide')
                                <span class="badge bg-success">Validé</span>
                                @elseif($dossier->statut === 'rejete')
                                <span class="badge bg-danger">Rejeté</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('regie.adhesion.detail', $dossier->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                    📄 Voir détail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aucun dossier trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection