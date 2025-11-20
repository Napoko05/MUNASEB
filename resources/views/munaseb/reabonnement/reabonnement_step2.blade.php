@extends('layouts.app')

@section('title', 'Réabonnement - Étape 2')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Étape 2 : Modifier vos informations personnelles</h2>

    <form action="{{ route('munaseb.reabonnement.postStep2') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Type de document</label>
            <input type="text" name="typedoc" class="form-control" value="{{ old('typedoc', $adherant->typedoc) }}">
        </div>

        <div class="mb-3">
            <label>Numéro de document</label>
            <input type="text" name="numdoc" class="form-control" value="{{ old('numdoc', $adherant->numdoc) }}">
        </div>

        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="tel1" class="form-control" value="{{ old('tel1', $adherant->tel1) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $adherant->email) }}">
        </div>

        <div class="mb-3">
            <label>Université</label>
            <input type="text" name="idUniversite" class="form-control" value="{{ old('idUniversite', $adherant->idUniversite) }}">
        </div>

        <div class="mb-3">
            <label>Filière</label>
            <input type="text" name="idFiliere" class="form-control" value="{{ old('idFiliere', $adherant->idFiliere) }}">
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('munaseb.reabonnement.reabonnementStep1') }}" class="btn btn-secondary">← Retour</a>
            <button type="submit" class="btn btn-primary">Suivant →</button>
        </div>
    </form>
</div>
@endsection
