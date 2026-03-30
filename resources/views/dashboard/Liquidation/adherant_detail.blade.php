@extends('layouts.liquidation_app')

@section('title', 'Détails Carte Adhérent')

@section('content')

<div class="dashboard-container">

    <div class="detail-card">

        {{-- HEADER --}}
        <div class="detail-header">
            Détails de l’adhérent :
            {{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}
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

        <div class="dashboard-body">

            {{-- =========================
                INFORMATIONS PRINCIPALES
            ========================= --}}
            <h5 class="section-title">Informations personnelles et académiques</h5>

            <table class="detail-table">

                <tr>
                    <th>Numéro de carte</th>
                    <td>
                        {{ $dossier->adherant->carte->numero_carte
                            ?? $dossier->adherant->numeroCarte 
                            ?? 'N/A' }}
                    </td>
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
                    <td>
                        {{ $dossier->adherant->dateNaiss 
                            ? \Carbon\Carbon::parse($dossier->adherant->dateNaiss)->format('d/m/Y') 
                            : 'N/A' }}
                        à {{ $dossier->adherant->lieuNaiss ?? 'N/A' }}
                    </td>
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
                        - {{ $dossier->adherant->codeNiveau ?? '' }}
                    </td>
                </tr>

                <tr>
                    <th>Date d'effet</th>
                    <td>
                        {{ \Carbon\Carbon::parse(
                            $dossier->adherant->carte->date_effet 
                            ?? $dossier->adherant->date_effet 
                            ?? now()
                        )->format('d/m/Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Date de validité</th>
                    <td>
                        {{ \Carbon\Carbon::parse(
                            $dossier->adherant->carte->date_validite 
                            ?? $dossier->adherant->date_validite 
                            ?? now()->addYear()
                        )->format('d/m/Y') }}
                    </td>
                </tr>

            </table>

            {{-- =========================
                PHOTO
            ========================= --}}
            <h5 class="section-title">Photo</h5>

            @if($dossier->adherant->photo)
            <img src="{{ asset('storage/'.$dossier->adherant->photo) }}"
                alt="Photo Adhérent"
                class="detail-photo">
            @else
            <div class="text-muted">Pas de photo disponible</div>
            @endif


            {{-- =========================
                INFORMATIONS IMPORTANTES
            ========================= --}}
            <h5 class="section-title">Informations importantes</h5>

            <table class="detail-table">

                <tr>
                    <th>En cas d'urgence</th>
                    <td>
                        {{ config('mutuelle.contact_urgence') ?? '70000000' }} <br>
                        {{ config('mutuelle.assistance') ?? 'ecenou@gmail.com' }} <br>
                        Centre Médical : {{ config('mutuelle.centre_partenaire') ?? 'Yalgado' }}
                    </td>
                </tr>

                <tr>
                    <th>Conditions d'utilisation</th>
                    <td>
                        Cette carte est personnelle et incessible.<br>
                        Toute falsification expose à des poursuites.<br>
                        Présenter avec une pièce d’identité valide.
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

            {{-- =========================
                ACTIONS
            ========================= --}}
            <div class="action-buttons">

                @if(!$dossier->adherant->carte)
                <a href="{{ route('liquidation.creerCarte', $dossier->adherant->id) }}"
                    class="btn btn-success">
                    💳 Créer Carte
                </a>
                @endif

                <a href="{{ route('liquidation.carte.edit', $dossier->adherant->id) }}"
                    class="btn btn-warning">
                    ✏️ Modifier
                </a>

                <form action="{{ route('liquidation.rejeter', $dossier->adherant->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Voulez-vous vraiment rejeter cet adhérent ?');">
                        ❌ Rejeter
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>

@endsection