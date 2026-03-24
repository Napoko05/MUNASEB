@extends('layouts.liquidation_app')

@section('title', 'Détails Carte Adhérent')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg rounded-4">
                
                <div class="card-header bg-primary text-white fw-bold">
                    Détails de l’adhérent : {{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}
                </div>

                <div class="card-body">

                    {{-- RECTO : Informations personnelles et académiques --}}
                    <h5 class="mb-3">Informations personnelles et académiques</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Numéro de carte</th>
                            <td>{{ $dossier->adherant->carte->numero_carte ?? $dossier->adherant->numeroCarte ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Nom</th>
                            <td>{{ $dossier->adherant->nom }}</td>
                        </tr>
                        <tr>
                            <th>Prénoms</th>
                            <td>{{ $dossier->adherant->prenom }}</td>
                        </tr>
                        <tr>
                            <th>Date et lieu de naissance</th>
                            <td>{{ \Carbon\Carbon::parse($dossier->adherant->dateNaiss)->format('d/m/Y') ?? 'N/A' }} à {{ $dossier->adherant->lieuNaiss ?? 'N/A' }}</td>
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
                            <td>{{ $dossier->adherant->filiere->nom ?? 'N/A' }} - {{ $dossier->adherant->codeNiveau ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Date d'effet</th>
                            <td>{{ \Carbon\Carbon::parse($dossier->adherant->carte->date_effet ?? $dossier->adherant->date_effet ?? now())->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Date de validité</th>
                            <td>{{ \Carbon\Carbon::parse($dossier->adherant->carte->date_validite ?? $dossier->adherant->date_validite ?? now()->addYear())->format('d/m/Y') }}</td>
                        </tr>
                    </table>

                    {{-- PHOTO --}}
                    <h5 class="mt-4">Photo</h5>
                    @if($dossier->adherant->photo)
                        <img src="{{ asset('storage/'.$dossier->adherant->photo) }}" alt="Photo Adhérent" class="img-fluid rounded mb-3">
                    @else
                        <div class="text-muted">Pas de photo disponible</div>
                    @endif

                    {{-- VERSO : Informations importantes --}}
                    <h5 class="mt-4">Informations importantes</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>En cas d'urgence</th>
                            <td>
                                {{ config('mutuelle.contact_urgence') ?? '70000000' }} <br>
                                {{ config('mutuelle.assistance') ?? 'ecenou@gmail.com' }} (Assistance Mutuelle)<br>
                                Centre Médical Partenaire : {{ config('mutuelle.centre_partenaire') ?? 'Yalgado' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Conditions d'utilisation</th>
                            <td>
                                Cette carte est personnelle et incessible.<br>
                                Toute falsification expose son auteur à des poursuites.<br>
                                Présenter la carte avec une pièce d’identité valide.
                            </td>
                        </tr>
                        <tr>
                            <th>Personne à contacter</th>
                            <td>
                                {{ $dossier->adherant->nomPrenomscasdebesoin ?? 'N/A' }}<br>
                                Contact : {{ $dossier->adherant->contactPersonnecasdebesoin ?? 'N/A' }}<br>
                                Lien : {{ $dossier->adherant->lienPersonnecasdebesoin ?? 'N/A' }}
                            </td>
                        </tr>
                    </table>

                    {{-- BOUTONS EN BAS --}}
                    <div class="mt-4 d-flex gap-2">
                        @if(!$dossier->adherant->carte)
                        <a href="{{ route('liquidation.creerCarte', $dossier->adherant->id) }}" class="btn btn-success">
                            💳 Créer Carte
                        </a>
                        @endif

                        <a href="{{ route('liquidation.carte.edit', $dossier->adherant->id) }}" class="btn btn-warning">
                            ✏️ Modifier
                        </a>

                        <form action="{{ route('liquidation.rejeterAdherant', $dossier->adherant->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment rejeter cet adhérent ?');">
                                ❌ Rejeter
                            </button>
                        </form>
                    </div>

                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div> {{-- col-md-12 --}}
    </div> {{-- row --}}
</div> {{-- container-fluid --}}
@endsection