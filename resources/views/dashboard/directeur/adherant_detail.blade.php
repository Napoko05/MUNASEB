@extends('layouts.directeur_app')

@section('title', 'Détails Carte Adhérent')

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        <div class="col-md-9">
            <div class="card shadow-lg rounded-4">

                {{-- HEADER --}}
                <div class="card-header bg-success text-white fw-bold">
                    Carte à signer : {{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}
                </div>

                <div class="card-body">

                    {{-- INFOS PRINCIPALES --}}
                    <h5>Informations personnelles</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Numéro carte</th>
                            <td>{{ $dossier->numero }}</td>
                        </tr>

                        <tr>
                            <th>INE</th>
                            <td>{{ $dossier->adherant->ine ?? 'N/A' }}</td>
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
                            <th>Email</th>
                            <td>{{ $dossier->adherant->email ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Téléphone</th>
                            <td>{{ $dossier->adherant->tel1 ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Université</th>
                            <td>{{ $dossier->adherant->universite->nom ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Filière</th>
                            <td>
                                {{ $dossier->adherant->filiere->nom ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Date création</th>
                            <td>
                                {{ \Carbon\Carbon::parse($dossier->created_at)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>

                    {{-- PHOTO --}}
                    <h5>Photo</h5>
                    @if($dossier->adherant->photo)
                        <img src="{{ asset('storage/'.$dossier->adherant->photo) }}"
                             class="img-fluid rounded mb-3"
                             style="max-height:200px;">
                    @else
                        <div class="text-muted">Pas de photo</div>
                    @endif

                    {{-- ACTIONS --}}
                    <div class="mt-4 text-center">

                        {{-- SIGNER --}}
                        @if(!$dossier->directeur_valide)
                            <form action="{{ route('directeur.carte_signer', $dossier->id) }}"
                                  method="POST">
                                @csrf

                                <button class="btn btn-success px-4">
                                    ✔️ Signer la carte
                                </button>
                            </form>
                        @else
                            <span class="badge bg-success p-2">
                                ✔️ Carte déjà signée
                            </span>
                        @endif

                        {{-- RETOUR --}}
                        <div class="mt-3">
                            <a href="{{ route('directeur.dashboard') }}"
                               class="btn btn-secondary">
                                ← Retour
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection