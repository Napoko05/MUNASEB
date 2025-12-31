@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        {{-- Sidebar gauche --}}
        <div class="col-md-3">
            @include('dashboard.regie_recette.partials.sidebar')
        </div>

        {{-- Contenu principal --}}
        <div class="col-md-9">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white fw-bold text-center">
                    Adhérents non validés
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adherants as $adherant)
                                    <tr>
                                        <td>{{ $adherant->nom }}</td>
                                        <td>{{ $adherant->prenom }}</td>
                                        <td>
                                            {{-- Bouton détail --}}
                                            <a href="{{ route('regie.adherant.detail', $adherant->id) }}" 
                                               class="btn btn-sm btn-outline-primary me-1">
                                                📄 Détail
                                            </a>

                                            {{-- Formulaire de validation --}}
                                            <form action="{{ route('regie.adherant.valider', $adherant->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">✔ Valider</button>
                                            </form>

                                            {{-- Bouton qui ouvre le modal de rejet --}}
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejeterModal{{ $adherant->id }}">
                                                ❌ Rejeter
                                            </button>

                                            {{-- Modal de rejet --}}
                                            <div class="modal fade" id="rejeterModal{{ $adherant->id }}" tabindex="-1" aria-labelledby="rejeterModalLabel{{ $adherant->id }}" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <form action="{{ route('regie.adherant.rejeter', $adherant->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header bg-danger text-white">
                                                      <h5 class="modal-title" id="rejeterModalLabel{{ $adherant->id }}">Motif du rejet</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <textarea name="motif_rejet" 
                                                                class="form-control" 
                                                                rows="3" 
                                                                placeholder="Expliquez le motif du rejet..." 
                                                                required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                      <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted">Aucun adhérent non validé.</td>
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
