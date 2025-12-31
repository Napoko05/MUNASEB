@extends('layouts.app')

@section('content')

<div class="sidebar shadow-sm">
    <h4 class="fw-bold">Directeur de la MUNASEB</h4>

    <a href="{{ route('directeur.dashboard') }}">Accueil</a>
    <a href="#">Agents</a>

    <!-- Cartes -->
    
        <a href="{{ route('directeur.cartes.a_creer') }}" class="btn btn-sm btn-primary">
            Créer sa carte
        </a>
        <a href="{{ route('directeur.cartes.listecarte') }}">Liste Cartes</a>

    <a href="{{ route('directeur.stats') }}">Statistiques</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="content-area">
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header text-white"
            style="background: linear-gradient(90deg, #007bff, #6610f2);">
            <h4 class="mb-0 fw-bold text-center">
                {{ $titre ?? 'Tableau de bord' }}
            </h4>
        </div>

        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table align-middle table-hover text-center">
                    <thead class="table-primary">
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
                            <td>{{ $dossier->adherant->nom ?? 'N/A' }}</td>
                            <td>{{ $dossier->adherant->prenom ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-success">Validé</span>
                            </td>
                            <td>
                                {{-- Voir détails dossier --}}
                                <a href="{{ route('directeur.dossier.voirDocument', $dossier->id) }}"
                                    class="btn btn-sm btn-info">
                                    Détail
                                </a>

                                {{-- Créer carte --}}
                                <form method="POST"
                                    action="{{ route('directeur.cartes.creer', $dossier->adherant->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">
                                        Créer carte
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Aucun adhérent en attente de carte.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection