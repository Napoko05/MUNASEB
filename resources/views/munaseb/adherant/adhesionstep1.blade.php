@extends('layouts.app_adherent')

@section('title', 'Adhésion Étudiant - Step 1')

@section('content')

<div class="container">

    ```
    <div class="register-card">

        <!-- HEADER -->
        <div class="step-header text-center">
            <h2>Étape 1 : Identification</h2>
            <p class="mb-0">Remplissez vos informations personnelles</p>
        </div>

        <!-- PROGRESS BAR -->
        <div class="progress mb-4" style="height:20px;">
            <div class="progress-bar" role="progressbar"
                style="width:33%"
                aria-valuenow="33"
                aria-valuemin="0"
                aria-valuemax="100">
                Étape 1 sur 3
            </div>
        </div>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('munaseb.adherant.postParentStep1') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-4">

                <!-- PHOTO -->
                <div class="col-md-3 d-flex flex-column align-items-center">
                    <label class="form-label">Photo (PNG/JPG 500x500)</label>

                    <div class="photo-placeholder mb-2">
                        <img id="photo_preview"
                            src="{{ asset('imag/photo-placeholder.png') }}"
                            alt="Aperçu photo">
                    </div>

                    <input type="file"
                        name="photo"
                        id="photo"
                        accept=".jpg,.jpeg,.png"
                        class="form-control">
                </div>

                <!-- CHAMPS -->
                <div class="col-md-9">

                    <!-- INE -->
                    <div class="mb-3">
                        <label>INE</label>
                        <input type="text"
                            name="ine"
                            placeholder="Ex : 2025000123"
                            required>
                    </div>

                    <!-- TYPE ADHERENT -->
                    <div class="mb-3">
                        <label>Type d’adhérent</label>
                        <select name="isBeneficiaire" class="form-control" required>
                            <option value="0">Étudiant</option>
                            <option value="1">Ayant droit</option>
                        </select>
                    </div>

                    <!-- NOM PRENOM -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Nom</label>
                            <input type="text" name="nom" required>
                        </div>

                        <div class="col-md-6">
                            <label>Prénoms</label>
                            <input type="text" name="prenom" required>
                        </div>
                    </div>

                    <!-- SEXE -->
                    <div class="mb-3 d-flex gap-4 align-items-center">
                        <label class="mb-0">Sexe :</label>

                        <div class="form-check">
                            <input type="radio" name="sexe" value="M" id="masculin" checked>
                            <label for="masculin">Masculin</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" name="sexe" value="F" id="feminin">
                            <label for="feminin">Féminin</label>
                        </div>
                    </div>

                    <!-- DATE NAISSANCE -->
                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label>Date de naissance</label>
                            <input type="date" name="dateNaiss" required>
                        </div>

                        <div class="col-md-6">
                            <label>Lieu de naissance</label>
                            <input type="text" name="lieuNaiss" required>
                        </div>

                    </div>

                </div>
            </div>

            <!-- BOUTONS -->
            <div class="form-navigation">

                <a href="{{ route('dashboard.etudiant') }}" class="btn btn-warning nav-btn">
                    Retour
                </a>

                <a href="{{ url()->previous() }}" class="btn btn-secondary nav-btn">
                    Annuler
                </a>

                <button type="submit" class="btn btn-cimaf nav-btn">
                    Suivant
                </button>

            </div>

        </form>

    </div>
    ```

</div>
@endsection

@push('scripts')

<script>
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo_preview');

    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            photoPreview.src = URL.createObjectURL(file);
        }
    });
</script>

@endpush