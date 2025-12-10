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
                <div class="card-header bg-primary text-white fw-bold">
                    Détails de l’adhérent : {{ $adherant->nom }} {{ $adherant->prenom }}
                </div>
                <div class="card-body">

                    {{-- Infos personnelles --}}
                    <h5>Informations personnelles</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Nom</th>
                            <td>{{ $adherant->nom }}</td>
                        </tr>
                        <tr>
                            <th>Prénom</th>
                            <td>{{ $adherant->prenom }}</td>
                        </tr>
                        <tr>
                            <th>INE</th>
                            <td>{{ $adherant->ine }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $adherant->email }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $adherant->tel1 }}</td>
                        </tr>
                        <tr>
                            <th>Filière</th>
                            <td>{{ $adherant->filiere->nom ?? '' }}</td>
                        </tr>
                    </table>
                    <h5>Documents soumis</h5>
                    <ul>
                        @if($adherant->dossier->document_cni)
                        <li>CNIB :
                            <a href="{{ asset('storage/' . $adherant->dossier->document_cni) }}" target="_blank">Voir</a>
                        </li>
                        @endif

                        @if($adherant->dossier->document_attestation)
                        <li>Attestation :
                            <a href="{{ asset('storage/' . $adherant->dossier->document_attestation) }}" target="_blank">Voir</a>
                        </li>
                        @endif

                        @if($adherant->dossier->document_recu)
                        <li>Reçu :
                            <a href="{{ asset('storage/' . $adherant->dossier->document_recu) }}" target="_blank">Voir</a>
                        </li>
                        @endif
                    </ul>

                    {{-- Enfants --}}
                    @if($adherant->enfants->count() > 0)
                    <h5>Enfants</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adherant->enfants as $enfant)
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
                    @if($adherant->conjoints->count() > 0)
                    <h5>Conjoints</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adherant->conjoints as $conjoint)
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

                    {{-- Boutons valider / rejeter --}}
                    <form action="{{ route('regie.adherant.valider', $adherant->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success mt-3">Valider l’adhérent</button>
                    </form>
                    <form action="{{ route('regie.adherant.rejeter', $adherant->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger mt-3"> Rejeter l’adhérent</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection