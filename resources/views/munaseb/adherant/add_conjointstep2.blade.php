@extends('layouts.app')

@section('title', 'Adhésion Étudiant - Step 2')

@section('content')
<div class="container-fluid p-0">
    <div class="bg-light vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="w-100" style="max-width: 900px;">
            <!-- Progress bar -->
            <div class="progress mb-4" style="height: 25px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">
                    Étape 2 sur 3
                </div>
            </div>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <h2 class="fw-bold mb-0">Étape 2 : Informations Académiques et Contact</h2>
                    <p class="mb-0">Complétez vos informations</p>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('munaseb.adherant.postConjointStep2') }}" method="POST">
                        @csrf

                        {{-- Type de document & numéro enfant --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Type de document</label>
                                <select name="typedoc" class="form-select" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="acte">Acte de Mariage</option>
                                    <option value="PASSPORT">Autre jugement supplétif d'acte de naissance</option>
                                </select>
                            </div>
                             {{-- Type de document & numéro  --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Type de document</label>
                                <select name="typedoc" class="form-select" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="Cart">Carte d'identité</option>
                                    <option value="PASSPORT">Passport</option>
                                    <option value="AUTRE">Autres</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Numéro d'acte de mariage</label>
                                <input type="text" name="numact" class="form-control" required>
                            </div>
                            {{-- N° Carte parent --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">N° Carte conjoint(e)</label>
                                <input type="number" name="numero" class="form-control" placeholder="Numero de carte conjoint(e) mutualiste" required>
                            </div>
                        </div>

                        {{-- Téléphone --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone 1</label>
                                <input type="text" name="tel1" class="form-control" placeholder="contact " required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone 2 (facultatif)</label>
                                <input type="text" name="tel2" class="form-control">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adresse Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email " required>
                        </div>

                        {{-- Personne à contacter --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nom & Prénoms (urgence)</label>
                                <input type="text" name="nomPrenomscasdebesoin" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Contact</label>
                                <input type="text" name="contactPersonnecasdebesoin" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Lien</label>
                                <input type="text" name="lienPersonnecasdebesoin" class="form-control" required>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('munaseb.adherant.adhesionstep1') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Précédent
                            </a>
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