<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Ici tu peux inclure ton CSS global -->
    <link rel="stylesheet" href="{{ asset('storage/assets/css/style.css') }}">
</head>
<body>

    {{-- Inclure le sidebar --}}
    @include('layouts.sidebar')

    {{-- Inclure le header --}}
    @include('layouts.head')

    {{-- Contenu principal de la page --}}
    <div class="main-content">
        <div class="container py-4">
            <h1>Bienvenue sur le Dashboard</h1>
            <p>Le contenu spécifique de la page s'affiche ici.</p>
        </div>
    </div>

    {{-- Inclure le footer --}}
    @include('layouts.footer')

    <!-- Scripts JS -->
    <script src="{{ asset('storage/assets/js/script.js') }}"></script>
</body>
</html>
