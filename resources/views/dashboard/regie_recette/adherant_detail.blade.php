@extends('layouts.regie')

@section('content')
<div class="d-flex">
    <main class="content-area flex-grow-1">

        <div class="adh-card adh-card-narrow">

            <!-- HEADER -->
            <div class="adh-card-header">
                Détails de l’adhérent : {{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}
            </div>
            {{-- Message succès --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Message erreur / rejet --}}
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="adh-card-body">

                <!-- INFOS PERSONNELLES -->
                <h5 class="adh-section-title">Informations personnelles</h5>
                <div class="table-responsive">
                    <table class="adh-table">
                        <tr>
                            <th>INE</th>
                            <td>{{ $dossier->adherant->ine }}</td>
                        </tr>
                        <tr>
                            <th>Nom</th>
                            <td>{{ $dossier->adherant->nom }}</td>
                        </tr>
                        <tr>
                            <th>Prénom</th>
                            <td>{{ $dossier->adherant->prenom }}</td>
                        </tr>
                        <tr>
                            <th>N° CNIB/Passport</th>
                            <td>{{ $dossier->adherant->numdoc->nom ?? 'Non renseigné' }}</td>
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
                            <th>Université</th>
                            <td>{{ optional($dossier->adherant->universite)->nom ?? 'Non renseigné' }}</td>
                        </tr>
                        <tr>
                            <th>Filière</th>
                            <td>{{ optional($dossier->adherant->filiere)->nom ?? 'Non renseigné' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- DOCUMENTS -->
                <h5 class="adh-section-title">Documents soumis</h5>
                <ul class="adh-doc-list">
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

                <!-- ENFANTS -->
                @if($dossier->adherant->enfants->count() > 0)
                <h5 class="adh-section-title">Enfants</h5>
                <div class="table-responsive">
                    <table class="adh-table text-center">
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
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_cni) }}" target="_blank" class="adh-btn-doc">CNI</a>
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_attestation) }}" target="_blank" class="adh-btn-doc">Attestation</a>
                                    <a href="{{ asset('storage/'.$enfant->dossier->document_recu) }}" target="_blank" class="adh-btn-doc">Reçu</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <!-- CONJOINTS -->
                @if($dossier->adherant->conjoints->count() > 0)
                <h5 class="adh-section-title">Conjoints</h5>
                <div class="table-responsive">
                    <table class="adh-table text-center">
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
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_cni) }}" target="_blank" class="adh-btn-doc">CNI</a>
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_attestation) }}" target="_blank" class="adh-btn-doc">Attestation</a>
                                    <a href="{{ asset('storage/'.$conjoint->dossier->document_recu) }}" target="_blank" class="adh-btn-doc">Reçu</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <!-- ACTIONS -->
                <div class="adh-btn-group mt-3">
                    @php $isActionPossible = !$dossier->valide && !$dossier->rejete; @endphp

                    <form action="{{ route('regie.adherant.valider', $dossier->adherant->id) }}" method="POST">
                        @csrf
                        <button class="adh-btn-success" {{ $isActionPossible ? '' : 'disabled' }}>Valider</button>
                    </form>

                    <button class="adh-btn-danger" data-bs-toggle="modal" data-bs-target="#rejeterModal{{ $dossier->adherant->id }}" {{ $isActionPossible ? '' : 'disabled' }}>Rejeter</button>

                    <a href="{{ route('regie.adherants.nonvalidees') }}" class="adh-btn-secondary">Retour</a>
                </div>

            </div>
        </div>

    </main>
</div>

<!-- MODAL -->
<div class="modal fade" id="rejeterModal{{ $dossier->adherant->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('regie.adherant.rejeter', $dossier->adherant->id) }}" method="POST">
                @csrf
                <div class="modal-header modal-header-danger">
                    <h5 class="modal-title">Motif du rejet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea name="motif_rejet" class="form-control" rows="3" placeholder="Expliquez le motif du rejet..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="adh-btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="adh-btn-danger">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection