@extends('layouts.app')

@section('title', 'Adhésion Étudiant - Step 1')

@section('content')
<div class="container-fluid p-0">
    <div class="bg-light vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="w-100" style="max-width: 900px;">

            <!-- Progress bar -->
            <div class="progress mb-4" style="height: 25px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
                    Étape 1 sur 3
                </div>
            </div>

            <!-- Card -->
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white py-4 rounded-top-4">
                    <h2 class="fw-bold mb-0 text-center">Étape 1 : Identification</h2>
                    <p class="mb-0 text-center">Remplissez vos informations personnelles</p>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('munaseb.adherant.postConjointStep1') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            {{-- Photo en haut gauche --}}
                            <div class="col-md-3 d-flex flex-column align-items-center">
                                <label class="form-label fw-semibold">Photo (PNG/JPG 500x500)</label>
                                <div class="photo-placeholder mb-2">
                                    <img id="photo_preview" src="{{ asset('imag/avatar-placeholder.png') }}" alt="Aperçu photo">
                                </div>
                                <input type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png" class="form-control">
                            </div>

                            {{-- Champs du Step 1 --}}
                            <div class="col-md-9">
                                {{-- INE --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">INE conjoint(e)</label>
                                    <input type="text" name="ine" class="form-control" placeholder="Ex : 2025000123" required>
                                </div>


                                {{-- Nom & Prénom --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nom</label>
                                        <input type="text" name="nom" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Prénoms</label>
                                        <input type="text" name="prenom" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Sexe --}}
                                <div class="mb-3 d-flex gap-4 align-items-center">
                                    <label class="form-label fw-semibold mb-0">Sexe :</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexe" value="M" id="masculin" checked>
                                        <label class="form-check-label" for="masculin">Masculin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexe" value="F" id="feminin">
                                        <label class="form-check-label" for="feminin">Féminin</label>
                                    </div>
                                </div>

                                {{-- Date & Lieu de naissance --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Date de naissance</label>
                                        <input type="date" name="dateNaiss" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Lieu de naissance</label>
                                        <input type="text" name="lieuNaiss" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Navigation --}}
                         <div class="d-flex justify-content-between">
                            {{-- Bouton Retour vers dashboard --}}
                            <a href="{{ route('dashboard.etudiant') }}" class="btn btn-warning">
                                Retour 
                            </a>

                            {{-- Bouton Annuler --}}
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                Annuler
                            </a>

                            {{-- Bouton Suivant --}}
                            <button type="submit" class="btn btn-primary">
                                Suivant <i class="fa fa-arrow-right ms-1"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview de l'image
    const avatarInput = document.getElementById('avatar');
    const photoPreview = document.getElementById('photo_preview');
    avatarInput.addEventListener('change', function(e) {
        const [file] = avatarInput.files;
        if (file) photoPreview.src = URL.createObjectURL(file);
    });
</script>
@endpush