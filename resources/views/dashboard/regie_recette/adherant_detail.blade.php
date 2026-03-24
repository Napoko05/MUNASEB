@extends('layouts.regie')

@section('content')
<div class="d-flex">
    <main class="content-area flex-grow-1">

        <div class="card shadow-lg rounded-4">
            <div class="card-header text-white"
                 style="background: linear-gradient(90deg, #007bff, #ff7f00); border-bottom: 2px solid #c62828;">
                Détails de l’adhérent : {{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}
            </div>

            <div class="card-body bg-light">

                {{-- Infos personnelles --}}
                <h5>Informations personnelles</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-sm table-bordered">
                        <tr><th>INE</th><td>{{ $dossier->adherant->ine }}</td></tr>
                        <tr><th>Nom</th><td>{{ $dossier->adherant->nom }}</td></tr>
                        <tr><th>Prénom</th><td>{{ $dossier->adherant->prenom }}</td></tr>
                        <tr><th>N° CNIB/Passport</th><td>{{ $dossier->adherant->numdoc->nom ?? 'Non renseigné' }}</td></tr>
                        <tr><th>Email</th><td>{{ $dossier->adherant->email }}</td></tr>
                        <tr><th>Téléphone</th><td>{{ $dossier->adherant->tel1 }}</td></tr>
                        <tr><th>Université</th><td>{{ optional($dossier->adherant->universite)->nom ?? 'Non renseigné' }}</td></tr>
                        <tr><th>Filière</th><td>{{ optional($dossier->adherant->filiere)->nom ?? 'Non renseigné' }}</td></tr>
                    </table>
                </div>

                {{-- Documents soumis --}}
                <h5>Documents soumis</h5>
                <ul class="mb-4">
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
                <div class="table-responsive mb-4">
                    <table class="table table-sm table-bordered text-center align-middle">
                        <thead class="table-light">
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
                </div>
                @endif

                {{-- Conjoints --}}
                @if($dossier->adherant->conjoints->count() > 0)
                <h5>Conjoints</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-sm table-bordered text-center align-middle">
                        <thead class="table-light">
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
                </div>
                @endif

                {{-- Actions directeur --}}
                <div class="btn-group-custom">
                    @php
                        $isActionPossible = !$dossier->valide && !$dossier->rejete;
                    @endphp

                    <form action="{{ route('regie.adherant.valider', $dossier->adherant->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success" {{ $isActionPossible ? '' : 'disabled' }}
                            onclick="{{ $isActionPossible ? '' : 'alert(\'Action non possible\'); return false;' }}">
                            Valider
                        </button>
                    </form>

                    <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#rejeterModal{{ $dossier->adherant->id }}"
                            {{ $isActionPossible ? '' : 'disabled' }}
                            onclick="{{ $isActionPossible ? '' : 'alert(\'Action non possible\'); return false;' }}">
                        Rejeter
                    </button>

                    <a href="{{ route('regie.adherants.nonvalidees') }}" class="btn btn-secondary">
                        Retour
                    </a>
                </div>

                {{-- Modal rejet --}}
                <div class="modal fade" id="rejeterModal{{ $dossier->adherant->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('regie.adherant.rejeter', $dossier->adherant->id) }}" method="POST">
                                @csrf
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Motif du rejet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea name="motif_rejet" class="form-control" rows="3"
                                              placeholder="Expliquez le motif du rejet..." required></textarea>
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
        </div> {{-- card --}}
    </main>
</div>
@endsection