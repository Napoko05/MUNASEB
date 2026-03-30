@extends('layouts.regie')

@section('title', 'Dashboard Régie Recette')

@section('content')

<div class="dashboard-content"> {{-- IMPORTANT --}}
    <div class="content-area">

        <h1>{{ $titre ?? 'Dashboard' }}</h1>

        <div class="row mb-4 justify-content-center text-center">
            <div class="col-12">
                <h2 class="fw-bold">
                    Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                </h2>
                <p class="text-muted">
                    Voici un aperçu de votre dashboard
                </p>
            </div>
        </div>

        <div class="row g-4">

            {{-- En attente --}}
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title">Demande en Attente</h6>
                        <p class="display-6">1</p>
                        <span class="badge bg-info">En attente</span>
                    </div>
                </div>
            </div>

            {{-- Validées --}}
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title">Adhésion traitée</h6>
                        <p class="display-6 text-success">12</p>
                        <span class="badge bg-success">Validées</span>
                    </div>
                </div>
            </div>

            {{-- Rejetées --}}
            <div class="col-lg-3 col-md-6">
                <div class="card card-danger text-center">
                    <div class="card-body">
                        <h6 class="card-title">Adhésion rejetées</h6>
                        <p class="display-6 text-danger">8</p>
                        <span class="badge bg-danger">Refusées</span>
                    </div>
                </div>
            </div>

            {{-- Mutualistes --}}
            <div class="col-lg-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title">Nombre de Mutualistes</h6>
                        <p class="display-6">11</p>
                        <span class="badge bg-info">Mutualistes</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection