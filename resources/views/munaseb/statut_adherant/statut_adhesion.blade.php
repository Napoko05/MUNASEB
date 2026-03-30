@extends('layouts.app_adherent')

@section('title', 'Vérification de ma demande')

@section('content')
<div class="container mt-5">

    {{-- FORMULAIRE --}}
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
                        <label class="form-label">INE</label>
                        <input type="text" class="form-control" name="ine" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Année de naissance</label>
                        <input type="number" class="form-control" name="annee_naissance" required>
                    </div>

                    <div class="d-flex justify-content-between mt-3">

                        <a href="{{ route('dashboard.etudiant') }}" class="btn btn-warning">
                            Annuler
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Vérifier ma demande
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RÉSULTAT --}}
    @isset($adherant)
    <div class="card shadow-lg">

        <div class="card-header bg-secondary text-white text-center py-3 rounded-top-4">
            <h3 class="fw-bold mb-0">Récapitulatif de votre demande</h3>
        </div>

        <div class="card-body p-4">

            <div class="row mb-4">

                <div class="col-md-3 text-center">
                    <img src="{{ $adherant->photo ? asset('storage/'.$adherant->photo) : asset('images/default-avatar.png') }}"
                         class="img-fluid rounded-circle mb-3">
                </div>

                <div class="col-md-9">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">
                            <strong>Nom :</strong> {{ $adherant->nom }} {{ $adherant->prenom }}
                        </li>

                        <li class="list-group-item">
                            <strong>INE :</strong> {{ $adherant->ine }}
                        </li>

                        <li class="list-group-item">
                            <strong>Sexe :</strong> {{ $adherant->sexe }}
                        </li>

                        <li class="list-group-item">
                            <strong>Date naissance :</strong> {{ $adherant->dateNaiss }}
                        </li>

                        <li class="list-group-item">
                            <strong>Université / Filière :</strong>
                            {{ $adherant->universite->nom ?? 'Non défini' }} /
                            {{ $adherant->filiere->nom ?? 'Non défini' }}
                        </li>

                    </ul>
                </div>
            </div>

            <hr>

            {{-- STATUT --}}
            <div class="text-center mt-4">

                <h4>Statut de la demande</h4>

                {{-- 🔴 REJET --}}
                @if($adherant->statut_global == 'rejete')

                    <p class="text-danger fw-bold">❌ Votre demande a été rejetée</p>

                    @php
                        $rejet = $adherant->visas->where('decision','rejete')->first();
                    @endphp

                    @if($rejet)
                        <p class="text-danger">
                            <strong>Motif :</strong> {{ $rejet->motif_rejet ?? 'Non précisé' }}
                        </p>
                    @endif

                {{-- 🟢 VALIDE --}}
                @elseif($adherant->statut_global == 'valide')

                    <p class="text-success fw-bold">
                        ✅ Votre demande a été validée
                    </p>

                    <a href="{{ route('carte.telecharger', $adherant->id) }}"
                       class="btn btn-success mt-2">
                        Télécharger ma carte
                    </a>

                {{-- 🟡 EN ATTENTE --}}
                @else

                    <p class="text-warning fw-bold">
                        ⏳ Votre demande est en cours de traitement
                    </p>

                @endif

            </div>

        </div>
    </div>
    @endisset

</div>
@endsection