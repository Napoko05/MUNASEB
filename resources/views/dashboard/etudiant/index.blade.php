@extends('layouts.app_adherent')

@section('title', 'Dashboard Étudiant')

@section('content')

{{-- BIENVENUE --}}
<section class="card border-danger mt-4 mx-auto limit-900">
    <div class="card-header bg-danger text-white text-center fw-bold">
        Bienvenue à la MUNASEB
    </div>
    <div class="card-body text-center">
        <img src="{{ asset('img/cenoulogo.png') }}" class="banner-img">
        <marquee class="text-success fw-bold mt-3">
            Bienvenue sur la plateforme E-MUNASEB – Vos droits, votre santé, notre engagement.
        </marquee>
    </div>
</section>

{{-- ÉTAPES --}}
<section class="card border-danger mt-5 mx-auto limit-900">
    <div class="card-header bg-danger text-white text-center fw-bold">
        Étapes d’adhésion à la MUNASEB
    </div>
    <div class="card-body">
        <ol class="list-group list-group-numbered">
            <li class="list-group-item">Créer un compte étudiant</li>
            <li class="list-group-item">Se connecter</li>
            <li class="list-group-item">Remplir le formulaire</li>
            <li class="list-group-item">Téléverser les pièces</li>
            <li class="list-group-item">Suivre la demande</li>
        </ol>
    </div>
</section>

{{-- INFOS --}}
<section class="general-info">
    <h2>À propos de la MUNASEB</h2>
    <p>La MUNASEB garantit la couverture sanitaire des étudiants du Burkina Faso.</p>
</section>

{{-- FAQ --}}
@include('dashboard.etudiant.partials.faq')

@endsection
