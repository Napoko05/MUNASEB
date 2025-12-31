@extends('layouts.app', ['hideNavbar' => true])

@section('content')

<div class="sidebar shadow-sm">
    <h4 class="fw-bold text-center py-3"> Régie Recette</h4>

    {{-- Accueil --}}
    <a href="{{ route('regie.dashboard') }}"> Accueil</a>

    {{-- Adhésions --}}
    <a data-bs-toggle="collapse" href="#adhesionsSubmenu" role="button" aria-expanded="false" aria-controls="adhesionsSubmenu">
        Adhésions non traitées
    </a>
    <div class="collapse submenu" id="adhesionsSubmenu">
        <a href="{{ route('regie.adherants.non_valide') }}"> Adhérents</a>
        <a href="{{ route('regie.enfants.non_valide') }}"> Enfants</a>
        <a href="{{ route('regie.conjoints.non_valide') }}"> Conjoints</a>
    </div>

    <a href="{{ route('regie.adherants.traitees') }}"> Adhésions traitées</a>


    {{-- Statistiques --}}
    <a href="#"> Statistiques</a>

    {{-- Déconnexion --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>
</div>

<div class="content-area">
    <div class="card shadow-lg">
        <div class="card-header text-white"
            style="background:linear-gradient(90deg,#007bff,#6610f2)">
            <h4 class="text-center">{{ $titre }}</h4>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
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
                        <td>{{ $dossier->adherant->nom }}</td>
                        <td>{{ $dossier->adherant->prenom }}</td>

                        <td class="text-center">
                            <span class="badge bg-warning">
                                En attente
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('regie.adherant.detail',$dossier->id) }}"
                                class="btn btn-sm btn-info">
                                Détail
                            </a>

                            <form method="POST"
                                action="{{ route('regie.adherant.valider',$dossier->id) }}"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">
                                    Valider
                                </button>
                            </form>

                            {{-- Bouton pour ouvrir le modal --}}
                            <button class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#rejeter{{ $dossier->id }}">
                                Rejeter
                            </button>

                            {{-- MODAL --}}
                            <div class="modal fade" id="rejeter{{ $dossier->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('regie.adherant.rejeter', $dossier->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Motif du rejet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="motif_rejet{{ $dossier->id }}" class="form-label">
                                                        Veuillez préciser le motif :
                                                    </label>
                                                    <textarea name="motif_rejet"
                                                        id="motif_rejet{{ $dossier->id }}"
                                                        class="form-control"
                                                        rows="4"
                                                        required></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Annuler
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    Confirmer le rejet
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Aucun dossier
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection