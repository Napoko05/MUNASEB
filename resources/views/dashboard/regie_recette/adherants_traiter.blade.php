@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('dashboard.regie_recette.partials.sidebar')
        </div>

        <div class="col-md-9">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold text-center">
                    Adhérents traités
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adherants as $adherant)
                                <tr>
                                    <td>{{ $adherant->nom }}</td>
                                    <td>{{ $adherant->prenom }}</td>
                                    <td>
                                        @if(optional($adherant->dossier)->statut === 'valide')
                                        <span class="badge bg-success">Validé</span>
                                        @elseif(optional($adherant->dossier)->statut === 'rejete')
                                        <span class="badge bg-danger">Rejeté</span>
                                        @if(!empty(optional($adherant->dossier)->motif_rejet))
                                        <div class="mt-1 text-muted small">
                                            <strong>Motif :</strong> {{ $adherant->dossier->motif_rejet }}
                                        </div>
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array(optional($adherant->dossier)->statut, ['valide', 'rejete']))
                                        <a href="{{ route('regie.adherant.detail', $adherant->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Modifier l’adhérent {{ $adherant->nom }} {{ $adherant->prenom }}">
                                            Modifier
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-muted">Aucun adhérent traité pour le moment.</td>
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