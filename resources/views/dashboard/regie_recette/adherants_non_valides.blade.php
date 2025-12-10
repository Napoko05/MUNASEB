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
                <div class="card-header bg-primary text-white fw-bold" style="text-align: center;">
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
                                            <a href="{{ route('regie.adherant.detail', $adherant->id) }}" class="btn btn-sm btn-outline-primary me-1">📄 Détail</a>
                                            <form action="{{ route('regie.adherant.valider', $adherant->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">✔ Valider</button>
                                            </form>
                                            <form action="{{ route('regie.adherant.rejeter', $adherant->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">❌ Rejeter</button>
                                            </form>
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
