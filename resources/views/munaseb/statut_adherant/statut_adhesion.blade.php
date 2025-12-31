@extends('layouts.app')

@section('title', 'Vérification de ma demande')

@section('content')
<div class="container mt-5">

    {{-- Formulaire de vérification --}}
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
            <h2 class="fw-bold mb-0">Vérifiez votre demande</h2>
        </div>
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('demande.verifier') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="ine" class="form-label">INE</label>
                        <input type="text" class="form-control" id="ine" name="ine" required>
                    </div>
                    <div class="col-md-6">
                        <label for="annee_naissance" class="form-label">Année de naissance</label>
                        <input type="number" class="form-control" id="annee_naissance" name="annee_naissance" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        {{-- Bouton Retour vers dashboard --}}
                        <a href="{{ route('dashboard.etudiant') }}" class="btn btn-warning">
                            Annuler
                        </a>
                    </div>
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-primary">Vérifier ma demande</button>
                    </div>
            </form>
        </div>
    </div>

    {{-- Résultat de la vérification --}}
    @isset($adherant)
    <div class="card shadow-lg">
        <div class="card-header bg-secondary text-white text-center py-3 rounded-top-4">
            <h3 class="fw-bold mb-0">Récapitulatif de votre demande</h3>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-3 text-center">
                    <img src="{{ $adherant->photo ? asset('storage/' . $adherant->photo) : asset('images/default-avatar.png') }}"
                        class="img-fluid rounded-circle mb-3" alt="Photo">
                    <p class="fw-semibold">Photo</p>
                </div>

                <div class="col-md-9">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nom complet :</strong> {{ $adherant->nom }} {{ $adherant->prenom }}</li>
                        <li class="list-group-item"><strong>INE :</strong> {{ $adherant->ine }}</li>
                        <li class="list-group-item"><strong>Sexe :</strong> {{ $adherant->sexe }}</li>
                        <li class="list-group-item"><strong>Date de naissance :</strong> {{ $adherant->dateNaiss }}</li>
                        <li class="list-group-item">
                            <strong>Université / Filière :</strong>
                            {{ $adherant->universites->nom ?? 'Non défini' }} /
                            {{ $adherant->filieres->nom ?? 'Non défini' }}
                        </li>
                    </ul>
                </div>
            </div>

            <hr>

            {{-- Statut de la demande --}}
            <div class="text-center mt-4">
                <h4>Statut de la demande</h4>

                @if($adherant->dossier && $adherant->dossier->statut === 'rejete')
                <p class="text-danger fw-bold">
                    Votre demande a été rejetée.
                </p>

                @if(!empty($adherant->dossier->motif_rejet))
                <p class="text-danger">
                    <strong>Motif :</strong> {{ $adherant->dossier->motif_rejet }}
                </p>
                @endif

                @elseif($adherant->dossier && $adherant->dossier->statut === 'valide')
                <p class="text-success fw-bold">
                    Votre demande a été validée !
                </p>

                <a href="{{ route('carte.telecharger', $adherant->id) }}"
                    class="btn btn-success mt-2">
                    Télécharger ma carte
                </a>

                @else
                <p class="text-warning fw-bold">
                    Votre demande est en cours de traitement.
                </p>
                @endif
            </div>
        </div>
    </div>
    @endisset

</div>
@endsection