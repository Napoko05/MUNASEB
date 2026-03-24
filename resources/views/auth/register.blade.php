@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- ALERTES SESSION --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ __('Inscription étudiant') }}
                </div>

                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        {{-- INE --}}
                        <div class="row mb-3">
                            <label for="ine" class="col-md-4 col-form-label text-md-end">{{ __('INE') }}</label>
                            <div class="col-md-6">
                                <input id="ine" type="text"
                                    class="form-control @error('ine') is-invalid @enderror"
                                    name="ine" value="{{ old('ine') }}" required autofocus>
                                @error('ine')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Nom --}}
                        <div class="row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>
                            <div class="col-md-6">
                                <input id="nom" type="text"
                                    class="form-control @error('nom') is-invalid @enderror"
                                    name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Prénom --}}
                        <div class="row mb-3">
                            <label for="prenom" class="col-md-4 col-form-label text-md-end">{{ __('Prénom') }}</label>
                            <div class="col-md-6">
                                <input id="prenom" type="text"
                                    class="form-control @error('prenom') is-invalid @enderror"
                                    name="prenom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Adresse e-mail') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Mot de passe --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirmation mot de passe --}}
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmer le mot de passe') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>
                        </div>

                        {{-- Bouton d’envoi et annuler --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex justify-content-between">
                                <a href="{{ route('login') }}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Inscription') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection