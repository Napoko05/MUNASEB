@extends('layouts.app')

@section('title', 'Conjoint - Récapitulatif')

@section('content')
<div class="container-fluid p-0">
    <div class="vh-100 d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow-lg rounded-4 w-100" style="max-width: 900px;">
            <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                <h2 class="fw-bold mb-0">Récapitulatif du conjoint</h2>
                <p class="mb-0">Vérifiez les informations avant de soumettre</p>
            </div>

            <div class="card-body p-5">
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        @if($data['avatar'])
                        <img src="{{ asset('storage/'.$data['avatar']) }}" class="img-fluid rounded-circle mb-3" alt="Photo">
                        @else
                        <img src="{{ asset('imag/avatar-placeholder.png') }}" class="img-fluid rounded-circle mb-3" alt="Photo">
                        @endif
                        <p class="fw-semibold">Photo</p>
                    </div>
                    <div class="col-md-9">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nom complet :</strong> {{ $data['step1']['nom'] }} {{ $data['step1']['prenom'] }}</li>
                            <li class="list-group-item"><strong>Sexe :</strong> {{ $data['step1']['sexe'] }}</li>
                            <li class="list-group-item"><strong>Date de naissance :</strong> {{ $data['step1']['dateNaiss'] }}</li>
                            <li class="list-group-item"><strong>Lieu de naissance :</strong> {{ $data['step1']['lieuNaiss'] }}</li>
                            <li class="list-group-item"><strong>Type doc :</strong> {{ $data['step2']['typedoc'] }} - {{ $data['step2']['numdoc'] }}</li>
                            <li class="list-group-item"><strong>Téléphone :</strong> {{ $data['step2']['tel1'] }}</li>
                            <li class="list-group-item"><strong>Email :</strong> {{ $data['step2']['email'] }}</li>
                        </ul>
                    </div>
                </div>

                <form action="{{ route('conjoint.soumettre') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('conjoint.step3') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Précédent
                        </a>
                        <button type="submit" class="btn btn-success">
                            Soumettre <i class="fa fa-check ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
