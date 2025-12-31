@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        {{-- Sidebar gauche --}}
        <div class="col-md-3">
            @include('dashboard.directeur.partials.sidebar')
        </div>

        {{-- Contenu principal --}}
        <div class="col-md-9">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold text-center">
                    Liste des cartes
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Numéro</th>
                                    <th>Adhérent</th>
                                    <th>Statut</th>
                                    <th>Date effet</th>
                                    <th>Date validité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartes as $carte)
                                <tr>
                                    <td>{{ $carte->numero_carte }}</td>
                                    <td>
                                        @if($carte->adherant)
                                            {{ $carte->adherant->nom }} {{ $carte->adherant->prenom }}
                                        @else
                                            <span class="text-muted">Adhérent inconnu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($carte->adherant && $carte->adherant->dossier)
                                            @if($carte->adherant->dossier->statut === 'valide')
                                                <span class="badge bg-success">Validé</span>
                                            @elseif($carte->adherant->dossier->statut === 'rejete')
                                                <span class="badge bg-danger">Rejeté</span>
                                            @else
                                                <span class="badge bg-secondary">En attente</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Inconnu</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $carte->date_effet ? \Carbon\Carbon::parse($carte->date_effet)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $carte->date_validite ? \Carbon\Carbon::parse($carte->date_validite)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        {{-- Action voir carte --}}
                                        <a href="{{ route('directeur.cartes.show', $carte->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                           Voir carte
                                        </a>

                                        {{-- Si rejeté, afficher motif --}}
                                        @if($carte->adherant && $carte->adherant->dossier && $carte->adherant->dossier->statut === 'rejete')
                                            <span class="d-block text-danger mt-1">
                                                Motif : {{ $carte->adherant->dossier->motif_rejet }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-muted">Aucune carte créée pour le moment.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
