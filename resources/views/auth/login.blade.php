<!doctype html>
<html lang="fr">

<head>
    <title>Connexion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- Icons & Styles -->
    <link rel="stylesheet" href="{{ asset('storage/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('storage/assets/css/style-preset.css') }}" />
</head>

<body data-pc-header="header-1" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">



    <!-- Préchargeur -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main v1 bg-grd-primary">
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('storage/assets/images/logo-dark.svg') }}" alt="logo" class="img-fluid mb-4" />
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif


                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="form-group mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Remember & Password Reset -->
                            <div class="d-flex mt-1 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">
                                        Se souvenir de moi ?
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-primary fw-400 text-decoration-none">
                                    Mot de passe oublié ?
                                </a>
                                @endif
                            </div>

                            <!-- Bouton Connexion -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Connexion</button>
                            </div>
                        </form>

                        <div class="saprator my-3">
                            <span>Ou créer un compte</span>
                        </div>

                        <div class="text-center">
                            <p class="mb-4">
                                Vous n'avez pas de compte ?
                                <a href="{{ route('register') }}" class="link-primary ms-1">Créer un compte</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('storage/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('storage/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('storage/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('storage/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('storage/assets/js/script.js') }}"></script>
    <script src="{{ asset('storage/assets/js/theme.js') }}"></script>
    <script src="{{ asset('storage/assets/js/plugins/feather.min.js') }}"></script>

</body>

</html>