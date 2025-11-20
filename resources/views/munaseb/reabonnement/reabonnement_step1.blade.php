@extends('layouts.app')
@section('title', 'Réabonnement - Étape 1')
@section('content')
<div class="container py-5">
    <h2>Étape 1 : Informations personnelles (non modifiable)</h2>
    <div class="card p-4 shadow-sm">
        <div><strong>INE :</strong> {{ $adherant->ine }}</div>
        <div><strong>Nom :</strong> {{ $adherant->nom }}</div>
        <div><strong>Prénom :</strong> {{ $adherant->prenom }}</div>
        <div><strong>Email :</strong> {{ $adherant->email }}</div>
        <div><strong>Téléphone :</strong> {{ $adherant->tel1 }}</div>
    </div>
    <div class="mt-4 d-flex justify-content-between">
        <a href="{{ route('dashboard.etudiant') }}" class="btn btn-secondary">Annuler</a>
        <a href="{{ route('munaseb.adherant.reabonnement.reabonnementStep2') }}" class="btn btn-primary">Suivant</a>
    </div>
</div>
@endsection
