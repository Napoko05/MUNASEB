@extends('layouts.app_adherent')

@section('title', 'Adhésion Étudiant - Step 2')

@section('content')
<div class="container">

    <div class="register-card">

        <!-- HEADER -->
        <div class="step-header">
            <h2>Étape 2 : Informations Académiques et Contact</h2>
            <p>Complétez vos informations</p>
        </div>

        <!-- PROGRESS BAR -->
        <div class="progress mb-4">
            <div class="progress-bar" style="width:66%">
                Étape 2 sur 3
            </div>
        </div>

        <form action="{{ route('munaseb.adherant.postParentStep2') }}" method="POST">
            @csrf

            <!-- DOCUMENT -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Type de document</label>
                    <select name="typedoc" required>
                        <option value="">Sélectionner...</option>
                        <option value="CNI">Carte Nationale d’Identité</option>
                        <option value="PASSPORT">Passeport</option>
                        <option value="AUTRE">Autre</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Numéro du document</label>
                    <input type="text" name="numdoc" required>
                </div>
            </div>

            <!-- TELEPHONE -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Téléphone 1</label>
                    <input type="text" name="tel1" required>
                </div>
                <div class="col-md-6">
                    <label>Téléphone 2 (facultatif)</label>
                    <input type="text" name="tel2">
                </div>
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label>Adresse Email</label>
                <input type="email" name="email" required>
            </div>

            <!-- UNIVERSITE & FILIERE -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Université</label>
                    <select name="idUniversite" id="universite" class="form-select" required>
                        <option value="">Sélectionner...</option>
                        @foreach(\App\Models\espace_adherant\Universite::all() as $universite)
                            <option value="{{ $universite->id }}">{{ $universite->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Filière</label>
                    <select name="idFiliere" id="filiere" class="form-select" required>
                        <option value="">Sélectionner la filière</option>
                        {{-- Les options seront injectées dynamiquement via JS --}}
                    </select>
                </div>
            </div>

            <!-- PERSONNE CONTACT -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Nom & Prénoms (urgence)</label>
                    <input type="text" name="nomPrenomscasdebesoin" required>
                </div>
                <div class="col-md-4">
                    <label>Contact</label>
                    <input type="text" name="contactPersonnecasdebesoin" required>
                </div>
                <div class="col-md-4">
                    <label>Lien</label>
                    <input type="text" name="lienPersonnecasdebesoin" required>
                </div>
            </div>

            <!-- NAVIGATION -->
            <div class="form-navigation">
                <a href="{{ route('munaseb.adherant.adhesionstep1') }}" class="btn btn-secondary nav-btn">
                    ← Précédent
                </a>

                <button type="submit" class="btn btn-cimaf nav-btn">
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

    if (!universiteSelect) {
        console.error('Select université introuvable');
        return;
    }

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
            .catch(err => {
                console.error(err);
                filiereSelect.innerHTML = '<option value="">Erreur chargement</option>';
            });
    });

});
</script>
@endpush