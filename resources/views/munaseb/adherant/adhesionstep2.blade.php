@extends('layouts.app_adherent')

@section('title', 'Adhésion Étudiant - Step 2')

@section('content')
<div class="container py-4">

    <div class="register-card">

        <!-- HEADER -->
        <div class="step-header text-center">
            <h2>Étape 2 : Informations Académiques et Contact</h2>
            <p class="mb-0">Complétez vos informations</p>
        </div>

        <!-- PROGRESS BAR -->
        <div class="progress mb-4">
            <div class="progress-bar" style="width:66%">
                Étape 2 sur 3
            </div>
        </div>

        <form action="{{ route('munaseb.adherant.postParentStep2') }}" method="POST">
            @csrf

            <!-- DOCUMENT + EMAIL -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Type de document</label>
                    <select name="typedoc" class="form-select" required>
                        <option value="">Sélectionner...</option>
                        <option value="CNI">CNIB</option>
                        <option value="PASSPORT">Passeport</option>
                        <option value="AUTRE">Autres</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Numéro</label>
                    <input type="text" name="numdoc" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', Auth::user()->email) }}"
                        class="form-control" required>
                </div>
            </div>

            <!-- TELEPHONE -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Téléphone principal</label>
                    <input type="text" name="tel1" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Téléphone secondaire</label>
                    <input type="text" name="tel2" class="form-control">
                </div>
            </div>

            <!-- UNIVERSITE & FILIERE -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Université</label>
                    <select name="idUniversite" id="universite" class="form-select" required>
                        <option value="">Sélectionner...</option>
                        @foreach(\App\Models\espace_adherant\Universite::all() as $universite)
                            <option value="{{ $universite->id }}">{{ $universite->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Filière</label>
                    <select name="idFiliere" id="filiere" class="form-select" required>
                        <option value="">Sélectionner la filière</option>
                    </select>
                </div>
            </div>

            <!-- PERSONNE CONTACT -->
            <div class="row mb-4">
                <div class="col-md-5">
                    <label class="form-label">Nom & Prénoms</label>
                    <input type="text" name="nomPrenomscasdebesoin" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="contactPersonnecasdebesoin" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Lien</label>
                    <input type="text" name="lienPersonnecasdebesoin" class="form-control" required>
                </div>
            </div>

            <!-- NAVIGATION -->
            <div class="form-navigation d-flex justify-content-between">
                <a href="{{ route('munaseb.adherant.adhesionstep1') }}" class="btn btn-secondary">
                    ← Précédent
                </a>

                <button type="submit" class="btn btn-cimaf">
                    Suivant →
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const universiteSelect = document.getElementById('universite');
    const filiereSelect = document.getElementById('filiere');

    universiteSelect.addEventListener('change', function() {
        const uniId = this.value;
        filiereSelect.innerHTML = '<option>Chargement...</option>';

        if(!uniId) {
            filiereSelect.innerHTML = '<option value="">Sélectionner la filière</option>';
            return;
        }

        fetch(`/filieres/${uniId}`)
            .then(res => res.json())
            .then(data => {
                filiereSelect.innerHTML = '<option value="">Sélectionner la filière</option>';

                data.forEach(f => {
                    let option = document.createElement('option');
                    option.value = f.id;
                    option.textContent = f.nom;
                    filiereSelect.appendChild(option);
                });
            })
            .catch(() => {
                filiereSelect.innerHTML = '<option value="">Erreur chargement</option>';
            });
    });

});
</script>
@endpush