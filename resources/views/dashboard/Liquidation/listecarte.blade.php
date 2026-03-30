@extends('layouts.liquidation_app')

@section('content')

<div class="dashboard-container">

    <div class="dashboard-card liscart-card">

        {{-- Header --}}
        <div class="dashboard-header liscart-header">
            <h4 class="dashboard-title">Adhésions traitées</h4>
        </div>

        {{-- Body --}}
        <div class="dashboard-body liscart-body">

            <div class="table-wrapper">
                <table class="dashboard-table liscart-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>N° Carte</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($cartes as $carte)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $carte->numero_carte }}</td>

                            <td>{{ $carte->adherant->nom }}</td>

                            <td>
                                @if($carte->adherant)
                                {{ $carte->adherant->prenom }}
                                @else
                                <span class="text-muted">Adhérent inconnu</span>
                                @endif
                            </td>

                            <td>
                                @if($carte->adherant && $carte->adherant->dossier)

                                @if($carte->adherant->dossier->statut === 'valide')
                                <span class="badge badge-success">carte créée</span>

                                @elseif($carte->adherant->dossier->statut === 'rejete')
                                <span class="badge badge-danger">Rejeté</span>

                                @else
                                <span class="badge badge-warning">En attente</span>
                                @endif

                                @else
                                <span class="badge badge-secondary">Inconnu</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-group">

                                    <a href="{{ route('liquidation.cartes.show', $carte->id) }}"
                                        class="btn btn-info btn-sm">
                                        Voir
                                    </a>

                                    {{-- Motif si rejet --}}
                                    @if($carte->adherant
                                    && $carte->adherant->dossier
                                    && $carte->adherant->dossier->statut === 'rejete')

                                    <div class="motif-box">
                                        Motif : {{ $carte->adherant->dossier->motif_rejet }}
                                    </div>

                                    @endif

                                </div>
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Aucune carte créée pour le moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div> {{-- body --}}
    </div> {{-- card --}}

</div>

@endsection