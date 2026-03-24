@extends('layouts.liquidation_app')

@section('title', 'Carte Adhérent')

@section('content')
<!-- CSS -->
@vite(['resources/css/liquidation/style_carte.css'])

{{-- ======================= RECTO ======================= --}}
<div class="card card-recto">

    {{-- HEADER --}}
    <div class="header">
        <h3>MUTUELLE SANTÉ</h3>
    </div>

    {{-- PHOTO --}}
    <div class="photo">
        <img src="{{ $adherant->photo 
            ? storage_path('app/public/'.$adherant->photo) 
            : public_path('images/default.png') }}">
    </div>

    {{-- INFOS --}}
    <div class="info">
        <h4 style="letter-spacing:1px;">
            CARTE N° {{ $adherant->carte->numero_carte ?? '' }}
        </h4>

        <p><b>ID :</b> {{ $adherant->id }}</p>

        <p><b>Nom :</b> {{ $adherant->nom }}</p>
        <p><b>Prénoms :</b> {{ $adherant->prenom }}</p>

        <p><b>Né le :</b> 
            {{ $adherant->dateNaiss 
                ? \Carbon\Carbon::parse($adherant->dateNaiss)->format('d/m/Y') 
                : '' }}
        </p>

        <p><b>Date effet :</b> 
            {{ $adherant->carte && $adherant->carte->date_effet 
                ? \Carbon\Carbon::parse($adherant->carte->date_effet)->format('d/m/Y') 
                : '' }}
        </p>

        <p><b>Validité :</b> 
            {{ $adherant->carte && $adherant->carte->date_validite 
                ? \Carbon\Carbon::parse($adherant->carte->date_validite)->format('d/m/Y') 
                : '' }}
        </p>

        <p><b>Université :</b> {{ $adherant->universite->nom ?? '' }}</p>
        <p><b>Filière :</b> {{ $adherant->filiere->nom ?? '' }}</p>

        <p><b>Contact :</b> {{ $adherant->tel1 ?? '' }}</p>
    </div>

    {{-- SIGNATURE --}}
    <div class="signature">
        @if($adherant->carte && $adherant->carte->signature_directeur)
            <img src="{{ storage_path('app/public/'.$adherant->carte->signature_directeur) }}">
            <span>Signature Directeur</span>
        @endif
    </div>

</div>

{{-- ======================= VERSO ======================= --}}
<div class="card card-verso page-break">

    <div class="title">INFORMATIONS IMPORTANTES</div>

    <div class="section">
        <p>
            {{ config('mutuelle.contact_urgence') ?? '' }}<br>
            Assistance : {{ config('mutuelle.assistance') ?? '' }}<br>
            Centre : {{ config('mutuelle.centre_partenaire') ?? '' }}
        </p>
    </div>

    <div class="section">
        <p>
            Carte personnelle et obligatoire.<br>
            Toute fraude est sanctionnée.<br>
            Présenter avec pièce d’identité.
        </p>
    </div>

    {{-- QR CODE --}}
    <div class="qr">
        @if($adherant->carte && $adherant->carte->qr_code_path)
            <img src="{{ storage_path('app/public/'.$adherant->carte->qr_code_path) }}">
        @endif
    </div>

</div>
@endsection