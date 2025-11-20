@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">

    {{-- ======== BARRE DE NAVIGATION ======== --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                🎓 Espace Étudiant
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEtudiant" aria-controls="navbarEtudiant" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarEtudiant">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {{-- Accueil --}}
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard.etudiant') }}">
                            🏠 Accueil
                        </a>
                    </li>

                    {{-- Menu déroulant Adhésion --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarAdhesion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ➕ Nouvelle Adhesion
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarAdhesion">
                            <li>
                                <a class="dropdown-item" href="{{ route('munaseb.adherant.adhesionstep1') }}"> Etudiant</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('munaseb.adherant.add_enfantstep1') }}"> Enfant</a>

                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('munaseb.adherant.add_conjointstep1') }}"> Conjoint(e)</a>
                            </li>

                        </ul>

                    </li>

                    {{-- Menu demande--}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarAdhesion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ➕ Nouveau Remboursement
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarAdhesion">
                            <li>
                                <a class="dropdown-item" href="{{ route('etudiant.adhesion.remboursement') }}"> Demande remboursement</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('munaseb.reabonnement.reabonnementStep1') }}"> Reabonnement</a>

                            </li>
                        </ul>

                    </li>

                   
                    {{-- Telechargement --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Telechargement
                        </a>
                    </li>
                    {{-- Profil --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('etudiant.profile.edit') }}">
                            👤 Profil
                        </a>
                    </li>

                </ul>

                {{-- Bouton Déconnexion --}}
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        🚪 Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ======== CONTENU DU TABLEAU DE BORD ======== --}}
    <div class="container mt-4">
        <h2 class="mb-3 text-primary">👩‍🎓 Tableau de bord - Étudiant</h2>
        <p>Bienvenue, <strong>{{ Auth::user()->name }}</strong> 👋</p>

        <div class="row mt-4">

            {{-- Mes bons --}}
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-success">🎫 Mes bons</h5>
                        <p class="text-muted">Consultez vos bons actifs ou utilisés.</p>
                        <a href="{{ route('etudiant.mesbons') }}" class="btn btn-sm btn-success">Voir mes bons</a>
                    </div>
                </div>
            </div>

            {{-- Historique des remboursements --}}
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-info">💳 Historique des paiements</h5>
                        <p class="text-muted">
                            Consultez vos cotisations passées et vos remboursements effectués.
                        </p>
                        <a href="{{ route('etudiant.historique') }}" class="btn btn-sm btn-info">Voir l’historique</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection