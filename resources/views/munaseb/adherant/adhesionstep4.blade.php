@extends('layouts.app_adherent')

@section('title', 'Adhésion Étudiant - Récapitulatif')

@section('content')

<style>
:root {
    --cimaf-blue: #0B4DA2;
    --cimaf-orange: #F58220;
    --cimaf-red: #D32F2F;
    --cimaf-gray-light: #F5F5F5;
}
body {
    font-size: 18px;
}

/* CONTAINER */
.container-center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: var(--cimaf-gray-light);
    padding: 20px;
}

/* CARD */
.recap-card {
    width: 100%;
    max-width: 900px;
    background: #fff;
    border-radius: 14px;
    padding: 35px;
    border: 2px solid var(--cimaf-red);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* HEADER */
.recap-header {
    background: var(--cimaf-blue);
    color: #fff;
    padding: 18px;
    border-radius: 12px 12px 0 0;
    margin: -35px -35px 30px;
    text-align: center;
    position: relative;
     height: 40px;
}

/* bande orange */
.recap-header::after {
    content: "";
    position: absolute;
    bottom: -6px;
    top : 30;
    left: 0;
    width: 100%;
    height: 8px;
    background: var(--cimaf-orange);
}

/* PHOTO */
.avatar {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid var(--cimaf-orange);
}

/* GRID RECAP */
.recap-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px 25px;
}

/* ITEM */
.recap-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.recap-item strong {
    display: block;
    margin-bottom: 4px;
}

/* FULL WIDTH */
.recap-item.full {
    grid-column: 1 / -1;
}

/* BUTTONS */
.form-buttons {
    display: flex;
    gap: 20px;
    margin-top: 35px;
}

.form-buttons .btn {
    flex: 1;
    padding: 13px;
    font-weight: 600;
    border-radius: 10px;
}

/* boutons */
.btn-retour {
    background: #fff;
    border: 2px solid #ccc;
}

.btn-submit {
    background: var(--cimaf-orange);
    color: #fff;
    border: none;
}

/* RESPONSIVE */
@media(max-width:768px) {
    .recap-grid {
        grid-template-columns: 1fr;
    }

    .form-buttons {
        flex-direction: column;
    }
}
</style>

<div class="container-center">

    <div class="recap-card">

        <!-- HEADER -->
        <div class="recap-header">
            <h2>Récapitulatif de votre demande</h2>
            <p>Vérifiez vos informations avant de soumettre</p>
        </div>

        <!-- PHOTO + INFOS -->
        <div class="row mb-4">

            <!-- PHOTO -->
            <div class="col-md-3 text-center">
                <img
                    src="{{ isset($data['step1']['avatar']) ? asset('storage/'.$data['step1']['avatar']) : asset('images/default-avatar.png') }}"
                    class="avatar mb-3"
                    alt="Photo">
            </div>

            <!-- INFOS -->
            <div class="col-md-9">

                <div class="recap-grid">

                    <div class="recap-item full">
                        <strong>Nom complet</strong>
                        {{ $data['step1']['nom'] }} {{ $data['step1']['prenom'] }}
                    </div>

                    <div class="recap-item">
                        <strong>INE</strong>
                        {{ $data['step1']['ine'] }}
                    </div>

                    <div class="recap-item">
                        <strong>Sexe</strong>
                        {{ $data['step1']['sexe'] }}
                    </div>

                    <!-- DATE + LIEU -->
                    <div class="recap-item">
                        <strong>Date naissance</strong>
                        {{ $data['step1']['dateNaiss'] }}
                    </div>

                    <div class="recap-item">
                        <strong>Lieu naissance</strong>
                        {{ $data['step1']['lieuNaiss'] }}
                    </div>

                    <!-- DOCUMENT -->
                    <div class="recap-item full">
                        <strong>Document</strong>
                        {{ $data['step2']['typedoc'] }} - {{ $data['step2']['numdoc'] }}
                    </div>

                    <!-- UNIVERSITE + FILIERE -->
                    <div class="recap-item">
                        <strong>Université</strong>
                        {{ $data['step2']['idUniversite'] }} 
                    </div>

                    <div class="recap-item">
                        <strong>Filière</strong>
                        {{ $data['step2']['idFiliere'] }}
                    </div>
                
                    <!-- CONTACT -->
                    <div class="recap-item">
                        <strong>Téléphone</strong>
                        {{ $data['step2']['tel1'] }}
                    </div>

                    <div class="recap-item">
                        <strong>Email</strong>
                        {{ $data['step2']['email'] }}
                    </div>

                </div>

            </div>

        </div>

        <!-- FORM -->
        <form action="{{ route('munaseb.adherant.soumettre') }}" method="POST">
            @csrf

            <div class="form-buttons">

                <a href="{{ route('munaseb.adherant.adhesionstep3') }}" class="btn btn-retour">
                    ← Précédent
                </a>

                <button type="submit" class="btn btn-submit">
                    Soumettre ✓
                </button>

            </div>

        </form>

    </div>

</div>

@endsection