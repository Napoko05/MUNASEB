@extends('layouts.directeur_app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        {{-- Contenu principal --}}
        <div class="col-md-9">
            <div class="card shadow-lg rounded-4 liscart-card">

                {{-- Header --}}
                <div class="card-header text-white fw-bold text-center liscart-header">
                    Liste des cartes
                </div>

                {{-- Body --}}
                <div class="card-body liscart-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle liscart-table">
                            <thead>
                                <tr>
                                    <th>N° Carte</th>
                                    <th>Nom</th>
                                     <th>Prénom</th>
                                    <th>Statut</th>
                                    <th>Date effet</th>
                                    <th>Date validité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartes as $carte)
                                <tr>
                                    <td data-label="Numéro">{{ $carte->numero_carte }}</td>
                                     <td data-label="Nom">{{ $carte->adherant->nom }}</td>
                                    <td data-label="Prenom">
                                        @if($carte->adherant)
                                             {{ $carte->adherant->prenom }}
                                        @else
                                            <span class="text-muted">Adhérent inconnu</span>
                                        @endif
                                    </td>
                                    <td data-label="Statut">
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
                                    <td data-label="Date effet">{{ $carte->date_effet ? \Carbon\Carbon::parse($carte->date_effet)->format('d/m/Y') : '-' }}</td>
                                    <td data-label="Date validité">{{ $carte->date_validite ? \Carbon\Carbon::parse($carte->date_validite)->format('d/m/Y') : '-' }}</td>
                                        
                                         <td data-label="Actions">
                                        @if(!$carte->signature_directeur)
                                            <a href="{{ route('directeur.cartes.liste', $carte->id) }}" class="btn btn-sm btn-outline-primary mb-1">
                                            Voir carte
                                        </a>
                                        @endif
                                        <a href="{{ route('directeur.carte.telecharger', $carte->adherant->id) }}" class="btn btn-sm btn-primary mt-1">Télécharger</a>
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

                </div> {{-- liscart-body --}}
            </div> {{-- liscart-card --}}
        </div> {{-- col-md-9 --}}
    </div> {{-- row --}}
</div> {{-- container-fluid --}}
@endsection