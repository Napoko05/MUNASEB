@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('dashboard.regie_recette.partials.sidebar')
        </div>

        <div class="col-md-9">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold">
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
                                            @if($adherant->dossier->statut == 'valide')
                                                <span class="badge bg-success">Validé</span>
                                            @elseif($adherant->dossier->statut == 'rejete')
                                                <span class="badge bg-danger">Rejeté </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{--le lien de voir dans la route--}}
                                            <a href="{{ route('regie.adherant.detail', $adherant->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>

                                            @if($adherant->dossier->statut == 'valide')
                                                <a href="{{ route('regie.adherant.creer_carte', $adherant->id) }}" class="btn btn-sm btn-info">Créer carte</a>
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
