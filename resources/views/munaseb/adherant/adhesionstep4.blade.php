@extends('layouts.app_adherent')

@section('title', 'Adhésion Étudiant - Récapitulatif')

@section('content')

<style>
/* ===============================
   VARIABLES CIMAF
================================ */
:root {
    --cimaf-blue: #0B4DA2;
    --cimaf-orange: #F58220;
    --cimaf-red: #D32F2F;
    --cimaf-gray-light: #F5F5F5;
}

/* CONTENEUR GLOBAL */
.container-center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: var(--cimaf-gray-light);
    padding: 20px;
}

/* CARTE */
.register-card {
    width: 100%;
    max-width: 900px;
    background: #fff;
    border-radius: 14px;
    padding: 35px;
    border: 2px solid var(--cimaf-red);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

/* HEADER */
.step-header {
    background: var(--cimaf-orange);
    color: #fff;
    padding: 18px;
    border-radius: 12px 12px 0 0;
    margin: -35px -35px 30px;
    text-align: center;
}

.step-header h2 {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 5px;
}

/* PHOTO */
.avatar {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid var(--cimaf-orange);
}

/* LISTE INFOS */
.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    padding: 12px 10px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
}

.info-list li strong {
    color: #333;
}

/* BOUTONS */
.form-buttons {
    display: flex;
    gap: 20px;
    margin-top: 35px;
}

.form-buttons .btn {
    flex: 1;
    padding: 13px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 10px;
}

.btn-retour {
    background: #fff;
    border: 2px solid #ccc;
}

.btn-submit {
    background: var(--cimaf-orange);
    border: none;
    color: #fff;
}

.btn-submit:hover {
    background: #d96f1c;
}

/* RESPONSIVE */
@media(max-width:768px) {
    .row {
        flex-direction: column;
        text-align: center;
    }

    .form-buttons {
        flex-direction: column;
    }
}
</style>

<div class="container-center">

    <div class="register-card">

        <div class="step-header">
            <h2>Récapitulatif de votre demande</h2>
            <p>Vérifiez vos informations avant de soumettre</p>
        </div>

        {{-- ALERTES DE SUCCÈS --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">

            <div class="col-md-3 text-center">

                <img
                    src="{{ isset($data['step1']['avatar']) ? asset('storage/'.$data['step1']['avatar']) : asset('images/default-avatar.png') }}"
                    class="avatar mb-3"
                    alt="Photo">

                <p class="fw-semibold">Photo</p>

            </div>

            <div class="col-md-9">

                <ul class="info-list">

                    <li><strong>Nom complet :</strong> {{ $data['step1']['nom'] }} {{ $data['step1']['prenom'] }}</li>
                    <li><strong>INE :</strong> {{ $data['step1']['ine'] }}</li>
                    <li><strong>Sexe :</strong> {{ $data['step1']['sexe'] }}</li>
                    <li><strong>Date de naissance :</strong> {{ $data['step1']['dateNaiss'] }}</li>
                    <li><strong>Lieu de naissance :</strong> {{ $data['step1']['lieuNaiss'] }}</li>
                    <li><strong>Type de document :</strong> {{ $data['step2']['typedoc'] }} - {{ $data['step2']['numdoc'] }}</li>
                    <li><strong>Université / Filière :</strong> {{ $data['step2']['idUniversite'] }} / {{ $data['step2']['idFiliere'] }}</li>
                    <li><strong>Téléphone :</strong> {{ $data['step2']['tel1'] }}</li>
                    <li><strong>Email :</strong> {{ $data['step2']['email'] }}</li>

                </ul>

            </div>

        </div>

        <form action="{{ route('munaseb.adherant.soumettre') }}" method="POST">
            @csrf

            <div class="form-buttons">

                <a href="{{ route('munaseb.adherant.adhesionstep3') }}" class="btn btn-retour">
                    ← Précédent
                </a>

                <button type="submit" class="btn btn-submit" onclick="this.disabled=true; this.form.submit();">
                    Soumettre ✓
                </button>

            </div>

        </form>

    </div>

</div>

@endsection