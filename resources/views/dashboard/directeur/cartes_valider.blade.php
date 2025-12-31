@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-3">
            @include('dashboard.directeur.partials.sidebar')
        </div>

        {{-- Contenu principal --}}
        <div class="col-md-9">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold text-center">
                    Adhérents validés
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle">
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
                                    <td>{{ $dossier->adherant->nom }}</td>
                                    <td>{{ $dossier->adherant->prenom }}</td>

                                    <td>
                                        @if($dossier->adherant->dossier && $dossier->adherant->dossier->statut === 'valide')
                                            <span class="badge bg-success">Validé</span>
                                        @else
                                            <span class="badge bg-secondary">Inconnu</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{-- Voir détails dossier --}}
                                        @if($dossier->adherant->dossier)
                                            <a href="{{ route('directeur.adhesion.detail', $dossier->adherant->dossier->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Voir
                                            </a>
                                        @endif

                                        {{-- Créer carte si non existante --}}
                                        @if(!$dossier->adherant->carte)
                                            <form action="{{ route('directeur.cartes.creer', $dossier->adherant->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Créer carte
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-info">Carte déjà créée</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-muted">
                                        Aucun adhérent validé pour le moment.
                                    </td>
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
