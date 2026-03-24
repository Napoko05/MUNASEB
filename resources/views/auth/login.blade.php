<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0b2a4a, #f57c00);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            position: relative;
            animation: fadeIn 0.6s ease;
        }

        .login-card::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            width: 100%;
            background: #f57c00;
            border-radius: 0 0 16px 16px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0b2a4a;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #0b2a4a;
            box-shadow: none;
        }

        .btn-primary {
            background: #0b2a4a;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #0d3b6a;
        }

        .btn-loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .spinner-border {
            width: 1rem;
            height: 1rem;
        }

        .logo {
            display: block;
            margin: 0 auto 15px;
            max-width: 100px;
        }

        .extra-links {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .extra-links a {
            color: #0b2a4a;
            text-decoration: none;
            font-weight: 500;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="login-card">

        <img src="{{ asset('storage/assets/images/elogo_colore.png') }}" class="logo">

        <h2>Connexion</h2>

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

        {{-- ERREURS DE VALIDATION --}}
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="mb-3">
                <label>Matricule / INE</label>
                <input type="text" name="login" class="form-control" value="{{ old('login') }}" required>
            </div>

            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Boutons -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" id="loginBtn">
                    <span id="btnText">Se connecter</span>
                    <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                </button>

                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    Annuler
                </a>
            </div>
        </form>

        <!-- Lien création -->
        <div class="extra-links">
            <p>Vous n'avez pas de compte ?</p>
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT PROPRE -->
    <script>
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');
        const text = document.getElementById('btnText');
        const loader = document.getElementById('btnLoader');

        form.addEventListener('submit', function() {
            btn.classList.add('btn-loading');
            text.textContent = "Connexion...";
            loader.classList.remove('d-none');
        });
    </script>

</body>

</html>