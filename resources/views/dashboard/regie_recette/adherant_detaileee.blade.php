@extends('layouts.regie')

@section('title', 'Détails Adhérent')

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        {{-- Sidebar gauche --}}
        <div class="col-md-3">
            @include('partials.regie_sidebar')
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
                            <td>{{ $adherant->nom ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Prénom</th>
                            <td>{{ $adherant->prenom ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>INE</th>
                            <td>{{ $adherant->ine ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $adherant->email ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $adherant->tel1 ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>N° CNIB/Passport</th>
                            <td>{{ $adherant->numdoc->nom ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Filière</th>
                            <td>{{ $adherant->filiere->nom ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Université</th>
                            <td>{{ $adherant->universite->nom ?? 'Non renseigné' }}</td>
                        </tr>
                    </table>

                    {{-- Documents soumis --}}
                    <h5 class="mt-3">Documents soumis</h5>
                    <ul>
                        @if($adherant->dossier)
                        @if($adherant->dossier->document_cni)
                        <li>CNIB : <a href="{{ asset('storage/' . $adherant->dossier->document_cni) }}" target="_blank">Voir</a></li>
                        @endif
                        @if($adherant->dossier->document_attestation)
                        <li>Attestation : <a href="{{ asset('storage/' . $adherant->dossier->document_attestation) }}" target="_blank">Voir</a></li>
                        @endif
                        @if($adherant->dossier->document_recu)
                        <li>Reçu : <a href="{{ asset('storage/' . $adherant->dossier->document_recu) }}" target="_blank">Voir</a></li>
                        @endif
                        @endif
                    </ul>

                    {{-- Enfants --}}
                    @if($adherant->enfants->count() > 0)
                    <h5 class="mt-3">Enfants</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adherant->enfants as $enfant)
                            <tr>
                                <td>{{ $enfant->nom ?? 'Non renseigné' }}</td>
                                <td>{{ $enfant->prenom ?? 'Non renseigné' }}</td>
                                <td>
                                    @if($enfant->dossier)
                                    @if($enfant->dossier->document_cni)
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_cni) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">CNI</a>
                                    @endif
                                    @if($enfant->dossier->document_attestation)
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_attestation) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Attestation</a>
                                    @endif
                                    @if($enfant->dossier->document_recu)
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_recu) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Reçu</a>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    {{-- Conjoints --}}
                    @if($adherant->conjoints->count() > 0)
                    <h5 class="mt-3">Conjoints</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adherant->conjoints as $conjoint)
                            <tr>
                                <td>{{ $conjoint->nom ?? 'Non renseigné' }}</td>
                                <td>{{ $conjoint->prenom ?? 'Non renseigné' }}</td>
                                <td>
                                    @if($conjoint->dossier)
                                    @if($conjoint->dossier->document_cni)
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_cni) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">CNI</a>
                                    @endif
                                    @if($conjoint->dossier->document_acte_mariage)
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_acte_mariage) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Acte Mariage</a>
                                    @endif
                                    @if($conjoint->dossier->document_recu)
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_recu) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Reçu</a>
                                    @endif
                                    @if($conjoint->dossier->document_carte)
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_carte) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Carte</a>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    {{-- Bouton retour --}}
                    <a href="{{ route('regie.adherants.non_valide') }}" class="btn btn-secondary mt-3">
                        Retour au tableau en attente
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection