@extends('layouts.app')

@section('title', 'Nouvelle adhésion en ligne')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
            <h2 class="fw-bold mb-0">Nouvelle Adhésion en Ligne</h2>
            <p class="text-light mb-0">Veuillez remplir soigneusement les informations ci-dessous</p>
        </div>

        <div class="card-body p-5">
            <form id="frm_adherant_new" action="{{ route('adherant.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Photo & Sexe --}}
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <div class="profile-upload">
                            <img id="photo_preview" src="{{ asset('images/avatar-placeholder.png') }}" alt="Aperçu photo" class="img-thumbnail rounded-circle mb-3" width="120" height="120">
                            <input type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexe" value="M" id="masculin" checked>
                                <label class="form-check-label" for="masculin">Masculin</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexe" value="F" id="feminin">
                                <label class="form-check-label" for="feminin">Féminin</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Type adhérant et INE --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Type d’adhérant</label>
                        <select name="isBeneficiaire" class="form-select">
                            <option value="0">Étudiant</option>
                            <option value="1">Ayant droit</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">INE</label>
                        <input type="text" name="ine" class="form-control" placeholder="Ex : 2025000123">
                    </div>
                </div>

                {{-- Nom et prénom --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom</label>
                        <input type="text" name="nom" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prénoms</label>
                        <input type="text" name="prenom" class="form-control">
                    </div>
                </div>

                {{-- Naissance --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date de naissance</label>
                        <input type="date" name="dateNaiss" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lieu de naissance</label>
                        <input type="text" name="lieuNaiss" class="form-control">
                    </div>
                </div>

                {{-- Document --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Type de document</label>
                        <select name="typedoc" class="form-select">
                            <option value="">Sélectionner...</option>
                            <option value="CNI">Carte Nationale d’Identité</option>
                            <option value="PASSPORT">Passeport</option>
                            <option value="AUTRE">Autre</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Numéro du document</label>
                        <input type="text" name="numdoc" class="form-control">
                    </div>
                </div>

                {{-- Contact --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone 1</label>
                        <input type="text" name="tel1" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone 2 (facultatif)</label>
                        <input type="text" name="tel2" class="form-control">
                    </div>
                </div>

                {{-- Email --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Adresse Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>

                {{-- Université & Filière --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Université</label>
                        <select name="idUniversite" class="form-select">
                            <option value="">Sélectionner...</option>
                            <option value="1">Université A</option>
                            <option value="2">Université B</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Filière</label>
                        <select name="idFiliere" class="form-select">
                            <option value="">Sélectionner...</option>
                            <option value="info">Informatique</option>
                            <option value="gestion">Gestion</option>
                        </select>
                    </div>
                </div>

                {{-- Personne à contacter en cas de besoin --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nom & Prénoms (urgence)</label>
                        <input type="text" name="nomPrenomscasdebesoin" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Contact</label>
                        <input type="text" name="contactPersonnecasdebesoin" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Lien</label>
                        <input type="text" name="lienPersonnecasdebesoin" class="form-control">
                    </div>
                </div>

                {{-- Boutons --}}
                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary me-3">
                        <i class="fa fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/espace_adherent/form_adherant.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/espace_adherent/form_adherant.js') }}"></script>
@endpush
