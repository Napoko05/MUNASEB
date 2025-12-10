<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Vite (app.scss doit inclure Bootstrap) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles spécifiques (chargés après Bootstrap pour override) -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/regie.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_etudiant.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/regie_recette/form_regie.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/etudiant/form-index.css') }}">

    <!-- Font Awesome (lien corrigé) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="" crossorigin="anonymous" />
</head>
<body>
    <div id="app">

        {{-- NAV PRINCIPALE — s'affiche seulement si hideNavbar n'est pas activé --}}
@if(!isset($hideNavbar))
<nav class="navbar navbar-expand-md custom-navbar shadow-sm">
    <div class="container custom-navbar-container">
        <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- LEFT -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- RIGHT -->
            <ul class="navbar-nav ms-auto">
                @guest
                    {{-- login + register --}}
                @else
                    <li class="nav-item"><a class="nav-link" href="#">🏠 Accueil</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
@endif


        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- si tu n'utilises pas Vite pour bootstrap JS, tu peux ajouter bootstrap bundle ici --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>
</html>
