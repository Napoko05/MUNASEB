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
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_etudiant.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/regie_recette/form_regie_index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/etudiant/form_index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style_administration.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />
</head>

<body>
    <div id="app">

        {{-- NAV PRINCIPALE — s'affiche seulement si hideNavbar n'est pas activé --}}
        @if(!isset($hideNavbar))
        <nav class="navbar navbar-expand-md custom-navbar shadow-sm">
            <div class="container custom-navbar-container">
                <a class="navbar-brand text-white fw-bold" href="#">
                    {{ config('app.name', '') }}
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
                        <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{ Auth::user()->prenom }} {{ Auth::user()->nom }}

                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
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

                {{-- 🔔 Messages flash --}}
                @if(session('info'))
                <div class="alert alert-info text-center fw-bold">
                    {{ session('info') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success text-center fw-bold">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger text-center fw-bold">
                    {{ session('error') }}
                </div>
                @endif

                {{-- CONTENU DES PAGES --}}
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Scripts Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoYz1Dh1J9l9j7x1Zl+PBkO5y5n1zV+0U5z5n5p5p5p5p5"
        crossorigin="anonymous"></script>

    @yield('scripts')
</body>

</html>