<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MUNASEB - Dashboard')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- CSS --}}
    @vite(['resources/css/liquidation/style_sidebar.css'])
    @vite(['resources/css/liquidation/style_carte.css'])
    @vite(['resources/css/liquidation/style_index.css'])
    @vite(['resources/css/liquidation/style_listecarte.css'])
    @vite(['resources/css/liquidation/style_detaill.css'])
    @vite('resources/css/footer.css')

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    @include('partials.liquidation')

    <!-- MAIN -->
    <main class="content-area">

        <!-- CONTENU -->
        <div class="container-fluid py-3">
            @yield('content')
        </div>

      

    </main>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @vite(['resources/js/app.js'])
    @vite(['resources/js/liquidation/script_liquidation.js'])
    @vite(['resources/js/liquidation/script_nonvalide.js'])
    

    @stack('scripts')
 @include('partials.footer')
</body>

</html>