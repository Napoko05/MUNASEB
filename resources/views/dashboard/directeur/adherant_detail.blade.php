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
                <div class="card-header bg-primary text-white fw-bold">
                    Détails de l’adhérent : {{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}
                </div>
                <div class="card-body">

                    {{-- Infos personnelles --}}
                    <h5>Informations personnelles</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Nom</th>
                            <td>{{ $dossier->adherant->nom }}</td>
                        </tr>
                        <tr>
                            <th>Prénom</th>
                            <td>{{ $dossier->adherant->prenom }}</td>
                        </tr>
                        <tr>
                            <th>INE</th>
                            <td>{{ $dossier->adherant->ine }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $dossier->adherant->email }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $dossier->adherant->tel1 }}</td>
                        </tr>
                        <tr>
                            <th>Filière</th>
                            <td>{{ $dossier->adherant->filiere->nom ?? '' }}</td>
                        </tr>
                    </table>

                    {{-- Documents soumis --}}
                    <h5>Documents soumis</h5>
                    <ul>
                        @if($dossier->document_cni)
                        <li>CNIB : <a href="{{ asset('storage/' . $dossier->document_cni) }}" target="_blank">Voir</a></li>
                        @endif
                        @if($dossier->document_attestation)
                        <li>Attestation : <a href="{{ asset('storage/' . $dossier->document_attestation) }}" target="_blank">Voir</a></li>
                        @endif
                        @if($dossier->document_recu)
                        <li>Reçu : <a href="{{ asset('storage/' . $dossier->document_recu) }}" target="_blank">Voir</a></li>
                        @endif
                    </ul>

                    {{-- Enfants --}}
                    @if($dossier->adherant->enfants->count() > 0)
                    <h5>Enfants</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dossier->adherant->enfants as $enfant)
                            <tr>
                                <td>{{ $enfant->nom }}</td>
                                <td>{{ $enfant->prenom }}</td>
                                <td>
                                    @if($enfant->dossier)
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_cni) }}" target="_blank" class="btn btn-sm btn-outline-primary">CNI</a>
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_attestation) }}" target="_blank" class="btn btn-sm btn-outline-primary">Attestation</a>
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_recu) }}" target="_blank" class="btn btn-sm btn-outline-primary">Reçu</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    {{-- Conjoints --}}
                    @if($dossier->adherant->conjoints->count() > 0)
                    <h5>Conjoints</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dossier->adherant->conjoints as $conjoint)
                            <tr>
                                <td>{{ $conjoint->nom }}</td>
                                <td>{{ $conjoint->prenom }}</td>
                                <td>
                                    @if($conjoint->dossier)
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_cni) }}" target="_blank" class="btn btn-sm btn-outline-primary">CNI</a>
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_attestation) }}" target="_blank" class="btn btn-sm btn-outline-primary">Attestation</a>
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_recu) }}" target="_blank" class="btn btn-sm btn-outline-primary">Reçu</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    {{-- Actions directeur --}}
                    <div class="mt-4">
                        {{-- Créer carte --}}
                        <form action="{{ route('directeur.cartes.creer', $dossier->adherant->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success">Créer carte</button>
                        </form>

                        {{-- Rejeter --}}
                        <button class="btn btn-danger d-inline" data-bs-toggle="modal" data-bs-target="#rejeterModal{{ $dossier->adherant->id }}">
                            Rejeter l’adhérent
                        </button>
                    </div>

                    {{-- Modal rejet --}}
                    <div class="modal fade" id="rejeterModal{{ $dossier->adherant->id }}" tabindex="-1" aria-labelledby="rejeterModalLabel{{ $dossier->adherant->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('directeur.adherant.rejeter', $dossier->adherant->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="rejeterModalLabel{{ $dossier->adherant->id }}">Motif du rejet</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="motif_rejet" class="form-control" rows="3" placeholder="Expliquez le motif du rejet..." required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> {{-- card-body --}}
            </div>
        </div>
    </div>
</div>
@endsection