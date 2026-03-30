@extends('layouts.directeur_app')

@section('title', 'Carte Adhérent')

@section('content')
<!-- Inclure le CSS spécifique -->
@vite(['resources/css/directeur/style_carte.css'])

{{-- ======================= RECTO ======================= --}}
<div class="card card-recto">
    <div class="photo">
        <img src="{{ public_path('storage/'.$adherant->photo) }}" alt="Photo Adhérent">
    </div>

    <div class="info">
        <h4>CARTE N° {{ $adherant->carte->numero_carte ?? $adherant->numeroCarte }}</h4>
        <p><b>Nom :</b> {{ $adherant->nom }}</p>
        <p><b>Prénoms :</b> {{ $adherant->prenom }}</p>
        <p><b>Né le :</b> {{ \Carbon\Carbon::parse($adherant->dateNaiss)->format('d/m/Y') }} à {{ $adherant->lieuNaiss }}</p>

        <p><b>Date d'effet :</b> {{ \Carbon\Carbon::parse($adherant->carte->date_creation ?? $adherant->date_effet)->format('d/m/Y') }}</p>
        <p><b>Date de validité :</b> {{ \Carbon\Carbon::parse($adherant->carte->date_validite ?? $adherant->date_validite)->format('d/m/Y') }}</p>

        <p><b>Université :</b> {{ $adherant->universites->nom }}</p>
        <p><b>Filière :</b> {{ $adherant->filieres->nom }} - {{ $adherant->codeNiveau }}</p>
        <p><b>Contact :</b> {{ $adherant->tel1 }}</p>
        @if($adherant->carte && $adherant->carte->signature_directeur)
        <div class="signature">
            <img src="{{ asset('storage/' . $adherant->carte->signature_directeur) }}"
                alt="Signature Directeur">
        </div>
        @endif
    </div>
</div>

{{-- ======================= VERSO ======================= --}}
<div class="card card-verso page-break">
    <div class="title">INFORMATIONS IMPORTANTES</div>

    <div class="section">
        <div class="section-title">En cas d'urgence :</div>
        <p>
            {{ config('mutuelle.contact_urgence') }} <br>
            {{ config('mutuelle.assistance') }} (Assistance Mutuelle)<br>
            Centre Médical Partenaire : {{ config('mutuelle.centre_partenaire') }}
        </p>
    </div>

    <div class="section">
        <div class="section-title">Conditions d’utilisation :</div>
        <p>
            Cette carte est personnelle et incessible.<br>
            Toute falsification expose son auteur à des poursuites.<br>
            Présenter la carte avec une pièce d’identité valide.
        </p>
    </div>

    <div class="qr">
        @if($adherant->carte && $adherant->carte->qr_code_path)
        <img src="{{ asset('storage/' . $adherant->carte->qr_code_path) }}" alt="QR Code">
        @endif
    </div>
</div>
@endsection