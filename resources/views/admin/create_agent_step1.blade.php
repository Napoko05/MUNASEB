@extends('layouts.app')

@section('content')
<div class="agent-page">
    <h2 class="agent-main-title">Créer un nouvel agent - Étape 1 : Informations</h2>

    @if($errors->any())
    <div class="agent-alert" style="display:block;">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="agent-form" action="{{ route('admin.agents.step2') }}" method="POST">
        @csrf

        <div class="agent-grid">
            <!-- Informations personnelles -->
            <div class="agent-field">
                <label>Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required>
            </div>

            <div class="agent-field">
                <label>Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required>
            </div>

            <div class="agent-field">
                <label>Sexe</label>
                <select name="sexe" required>
                    <option value="">Sélectionner</option>
                    <option value="Masculin" {{ old('sexe')=='Masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="Féminin" {{ old('sexe')=='Féminin' ? 'selected' : '' }}>Féminin</option>
                </select>
            </div>

            <div class="agent-field">
                <label>Lieu de naissance</label>
                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required>
            </div>

            <div class="agent-field">
                <label>Date de naissance</label>
                <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required>
            </div>

            <div class="agent-field">
                <label>N° CNIB</label>
                <input type="text" name="num_cnib" value="{{ old('num_cnib') }}" required>
            </div>

            <!-- Profession -->
            <div class="agent-field">
                <label>Service</label>
                <input type="text" name="service" placeholder="Ex: Régie des recettes, Liquidation, Finance..." value="{{ old('service') }}" required>
            </div>

            <div class="agent-field">
                <label>Matricule</label>
                <input type="text" name="matricule" value="{{ old('matricule') }}" required>
            </div>

            <div class="agent-field">
                <label>Ville du service</label>
                <input type="text" name="ville" value="{{ old('ville') }}" required>
            </div>

            <div class="agent-field">
                <label>Spécialité (optionnel)</label>
                <input type="text" name="specialite" value="{{ old('specialite') }}">
            </div>

            <!-- Contact -->
            <div class="agent-field">
                <label>Téléphone</label>
                <input type="text" name="tel" value="{{ old('tel') }}">
            </div>

            <div class="agent-field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="agent-field">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <div class="agent-field">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>

        <button type="submit" class="agent-btn-submit">Suivant</button>
    </form>
</div>
@endsection