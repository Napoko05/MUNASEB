@extends('layouts.liquidation_app')

@section('title', 'Modifier Carte Adhérent')

@section('content')

<div class="dashboard-container">

    <div class="detail-card">

        {{-- HEADER --}}
        <div class="detail-header">
            Modifier l’adhérent :
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
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="dashboard-body">

            <form action="{{ route('liquidation.carte.update', $dossier->adherant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- =========================
                    INFORMATIONS PRINCIPALES
                ========================= --}}
                <h5 class="section-title">Informations personnelles et académiques</h5>

                <table class="detail-table">

                    <tr>
                        <th>Numéro de carte</th>
                        <td>
                            <input type="text" name="numero_carte" class="form-control"
                                value="{{ old('numero_carte', $dossier->adherant->carte->numero_carte ?? $dossier->adherant->numeroCarte) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Nom</th>
                        <td>
                            <input type="text" name="nom" class="form-control"
                                value="{{ old('nom', $dossier->adherant->nom) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Prénoms</th>
                        <td>
                            <input type="text" name="prenom" class="form-control"
                                value="{{ old('prenom', $dossier->adherant->prenom) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Date de naissance</th>
                        <td>
                            <input type="date" name="dateNaiss" class="form-control"
                                value="{{ old('dateNaiss', $dossier->adherant->dateNaiss ? \Carbon\Carbon::parse($dossier->adherant->dateNaiss)->format('Y-m-d') : '') }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Lieu de naissance</th>
                        <td>
                            <input type="text" name="lieuNaiss" class="form-control"
                                value="{{ old('lieuNaiss', $dossier->adherant->lieuNaiss) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $dossier->adherant->email) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Téléphone</th>
                        <td>
                            <input type="text" name="tel1" class="form-control"
                                value="{{ old('tel1', $dossier->adherant->tel1) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Université</th>
                        <td>
                            <select name="universite_id" class="form-select">
                                @foreach($universites as $uni)
                                <option value="{{ $uni->id }}" {{ $dossier->adherant->universite_id == $uni->id ? 'selected' : '' }}>
                                    {{ $uni->nom }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Filière</th>
                        <td>
                            <select name="filiere_id" class="form-select">
                                @foreach($filieres as $fil)
                                <option value="{{ $fil->id }}" {{ $dossier->adherant->filiere_id == $fil->id ? 'selected' : '' }}>
                                    {{ $fil->nom }}
                                </option>
                                @endforeach
                            </select>
                            <input type="text" name="codeNiveau" class="form-control mt-1"
                                value="{{ old('codeNiveau', $dossier->adherant->codeNiveau) }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Date d'effet</th>
                        <td>
                            <input type="date" name="date_effet" class="form-control"
                                value="{{ old('date_effet', $dossier->adherant->carte->date_effet ?? $dossier->adherant->date_effet ? \Carbon\Carbon::parse($dossier->adherant->carte->date_effet ?? $dossier->adherant->date_effet)->format('Y-m-d') : '') }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Date de validité</th>
                        <td>
                            <input type="date" name="date_validite" class="form-control"
                                value="{{ old('date_validite', $dossier->adherant->carte->date_validite ?? $dossier->adherant->date_validite ? \Carbon\Carbon::parse($dossier->adherant->carte->date_validite ?? $dossier->adherant->date_validite)->format('Y-m-d') : '') }}">
                        </td>
                    </tr>

                    <tr>
                        <th>Photo</th>
                        <td>
                            @if($dossier->adherant->photo)
                            <img src="{{ asset('storage/'.$dossier->adherant->photo) }}"
                                alt="Photo Adhérent" class="detail-photo mb-2">
                            @endif
                            <input type="file" name="photo" class="form-control">
                        </td>
                    </tr>

                </table>

                {{-- =========================
                    INFORMATIONS IMPORTANTES
                ========================= --}}
                <h5 class="section-title mt-4">Informations importantes</h5>

                <table class="detail-table">

                    <tr>
                        <th>Personne à contacter</th>
                        <td>
                            <input type="text" name="nomPrenomscasdebesoin" class="form-control mb-1"
                                value="{{ old('nomPrenomscasdebesoin', $dossier->adherant->nomPrenomscasdebesoin) }}">
                            <input type="text" name="contactPersonnecasdebesoin" class="form-control mb-1"
                                placeholder="Contact"
                                value="{{ old('contactPersonnecasdebesoin', $dossier->adherant->contactPersonnecasdebesoin) }}">
                            <input type="text" name="lienPersonnecasdebesoin" class="form-control"
                                placeholder="Lien"
                                value="{{ old('lienPersonnecasdebesoin', $dossier->adherant->lienPersonnecasdebesoin) }}">
                        </td>
                    </tr>

                </table>

                {{-- =========================
                    ACTIONS
                ========================= --}}
                <div class="action-buttons mt-3">
                    <button type="submit" class="btn btn-success">💾 Enregistrer les modifications</button>
                    <a href="{{ route('liquidation.dossier.voirDocument', $dossier->adherant->id) }}" class="btn btn-secondary">🔙 Retour</a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection