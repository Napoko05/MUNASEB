<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Régie Recette')</title>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    {{-- Vite CSS --}}
    @vite([
    'resources/css/app.css',
    'resources/css/regie/style_sidebar.css',
    'resources/css/regie/blade_non_traite.css',
    'resources/css/regie/style_traite.css',
    'resources/css/regie/style_details.css',
    'resources/css/regie/style_index.css',
    'resources/css/regie/style_listecarte.css',
     'resources/css/footer.css',
    ])
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" defer></script>
</head>

<body>
    <div class="rh-wrapper">

        {{-- Sidebar --}}
        @include('partials.regie_sidebar')

        {{-- Contenu principal --}}
        <div class="rh-content">
            @yield('content')
        </div>
    </div>
    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Vite JS --}}
    @vite(['resources/js/regie/script_index.js'])
    @vite(['resources/js/regie/script_sidebar.js'])
    @vite(['resources/js/regie/script_detail.js'])
    @vite(['resources/js/regie/script_detail.js'])


    {{-- Scripts spécifiques --}}
    @yield('scripts')

    @stack('scripts')
    
 @include('partials.footer')
</body>

</html>