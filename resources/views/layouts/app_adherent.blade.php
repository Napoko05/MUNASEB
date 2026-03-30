<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'MUNASEB')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS adherent --}}
    @vite('resources/css/adherent/style_index.css')
    @vite('resources/css/adherent/style_partials.css')
    @vite('resources/css/adherent/style_faq.css')
    @vite('resources/css/footer.css')
    @vite('resources/css/adherent/style_adhesion.css')
    @vite('resources/css/adherent/style_index_adherent.css')
    @vite('resources/css/adherent/style_statut.css')

    @stack('styles')

</head>

<body>

    {{-- globale (navbar + slider + etc.) --}}
    @if(!($hideNavbar ?? false))
    @include('partials.adherent')
    @endif



    <div class="page-wrapper">

        <main class="content-wrapper">
            @yield('content')
        </main>

        @include('partials.footer')

    </div>
    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/script_index_adherent.js')
    @vite('resources/js/faq.js')
    @vite('resources/js/script_partials.js')

    @stack('scripts')


</body>

</html>