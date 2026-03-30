<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Carte N° {{ optional($dossier->adherant->carte)->numero_carte }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
        }

        /* ================= CARTE ================= */
        .card {
            width: 340px;
            height: 210px;
            border-radius: 12px;
            overflow: hidden;
            margin: auto;
            border: 2px solid #c62828;
            position: relative;
        }

        /* ================= RECTO ================= */
        .card-recto {
            background: #ffffff;
            position: relative;
        }

        /* bande verte légère en haut */
        .card-recto::before {
            content: "";
            position: absolute;
            top: 0;
            width: 100%;
            height: 25px;
            background: #5afab2;
            /* vert clair */
        }

        /* PHOTO (réduite) */
        .photo {
            position: absolute;
            top: 35px;
            left: 8px;
        }

        .photo img {
            width: 55px;
            height: 65px;
            border-radius: 6px;
            border: 1px solid #fff;
            object-fit: cover;
        }

        /* MUTUELLE */
        .mutuelle {
            position: absolute;
            top: 35px;
            left: 70px;
            font-weight: bold;
            font-size: 12px;
            color: #2e7d32;
        }

        .mutuelle-sub {
            font-weight: normal;
            font-size: 6.5px;
            margin-left: 2px;
        }

        /* INFOS OPTIMISÉES */
        .info {
            position: absolute;
            top: 100px;
            left: 8px;
            right: 8px;
            font-size: 9px;
            line-height: 1.2;
        }

        .info p {
            margin: 1px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        /* SIGNATURE */
        .signature {
            position: absolute;
            bottom: 8px;
            right: 8px;
            z-index: 2;
            /* toujours au-dessus */
        }

        .signature img {
            width: 55px;
        }

        /* ================= VERSO ================= */
        .card-verso {
            background: #5afab2;
            padding: 10px;
            position: relative;
            height: 210px;
            text-align: center;
            color: #ffffff;
        }

        /* LOGO FILIGRANE */
        .logo-bg {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 0;
            opacity: 0.1;
        }

        .logo-bg img {
            width: 120px;
            height: auto;
            filter: brightness(0) invert(1);
        }

        /* TITRE ET TEXTES */
        .card-verso .title {
            font-weight: bold;
            margin-bottom: 5px;
            border-bottom: 1px solid #ffffff;
            padding-bottom: 2px;
            font-size: 11px;
            z-index: 1;
            position: relative;
        }

        .card-verso .section {
            font-size: 9px;
            line-height: 1.4;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
        }

        .mutuelle {
            position: absolute;
            top: 35px;
            left: 70px;
            color: #2e7d32;
        }

        /* MUNASEB principal */
        .title-main {
            font-weight: bold;
            font-size: 12px;
        }

        /* ASSURANCE SANTÉ juste en dessous */
        .title-sub {
            font-size: 9px;
            font-weight: bold;
            color: #0B4DA2;
            /* bleu propre (style CIMAF 👍) */
            margin-top: -2px;
        }

        /* texte long */
        .mutuelle-sub {
            font-size: 6.5px;
            margin-top: 2px;
        }

        /* LOGO MUNASEB EN HAUT A DROITE */
        .logo-munaseb {
            position: absolute;
            top: 30px;
            right: 8px;
        }

        .logo-munaseb img {
            width: 50px;
            /* tu peux réduire encore (40px si tu veux) */
            height: auto;
        }

        /* QR */
        .qr {
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 2;
            /* au premier plan */
        }

        .qr img {
            width: 60px;
        }

        /* PAGE BREAK */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <!-- RECTO -->
    <div class="card card-recto">
        <div class="photo">
            <img src="{{ storage_path('app/public/'.($dossier->adherant->photo ?? 'images/default.png')) }}">
        </div>

        <div class="mutuelle">
            <div class="title-main">MUNASEB</div>
            <div class="mutuelle-sub">(Mutuelle Nationale de Santé des Étudiants Burkinabè)</div>
        </div>
        <div class="logo-munaseb">
            <img src="{{ public_path('assets/image/munaseb.png') }}">
        </div>

        <div class="info">
            <p><b>N° :</b> {{ optional($dossier->adherant->carte)->numero_carte }}</p>
            <p><b>{{ $dossier->adherant->nom }} {{ $dossier->adherant->prenom }}</b></p>

            <div class="row">
                <span><b>Né (le/en) :</b> {{ $dossier->adherant->dateNaiss ? \Carbon\Carbon::parse($dossier->adherant->dateNaiss)->format('d/m/Y') : '' }}</span>
                <span><b>A :</b> {{ $dossier->adherant->lieuNaiss ?? '' }}</span>
            </div>

            <p><b>INE :</b> {{ $dossier->adherant->ine ?? 'N/A' }}</p>
            <p><b>Université :</b> {{ $dossier->adherant->universite->nom ?? '' }}</p>
            <p><b>Filière :</b> {{ $dossier->adherant->filiere->nom ?? '' }}</p>

            <div class="row">
                <span><b>Date Effet :</b> {{ optional($dossier->adherant->carte)->date_effet ? \Carbon\Carbon::parse($dossier->adherant->carte->date_effet)->format('d/m/Y') : '' }}</span>
                <span><b>Date Validité :</b> {{ optional($dossier->adherant->carte)->date_validite ? \Carbon\Carbon::parse($dossier->adherant->carte->date_validite)->format('d/m/Y') : '' }}</span>
            </div>
        </div>

        <!-- SIGNATURE -->
        <div class="signature">
            @if(optional($dossier->adherant->agent)->signature_file)
            <img src="{{ storage_path('app/public/'.$dossier->adherant->agent->signature_file) }}">
            @endif
        </div>
    </div>


    <!-- VERSO -->
    <div class="card card-verso page-break">

        <!-- LOGO FILIGRANE -->
        <div class="logo-bg">
            <img src="{{ public_path('assets/image/cenou_logo.png') }}">
        </div>

        <!-- TITRE -->
        <div class="title">INFORMATIONS IMPORTANTES</div>
        <!-- CONTACT -->
        <div class="section">
            Urgence : {{ config('mutuelle.contact_urgence') ?? '70000000' }}<br>
            Assistance : {{ config('mutuelle.assistance') ?? 'ecenou@gmail.com' }}<br>
            Centre : {{ config('mutuelle.centre_partenaire') ?? 'Yalgado' }}
        </div>

        <!-- RÈGLES -->
        <div class="section">
            Carte à usage personnel uniquement.<br>
            Toute fraude ou tentative de fraude est sanctionnée.<br>
            A présenter lors des soins ou achats de vos produits.
        </div>

        <!-- CONTACT URGENCE -->
        <div class="section">
            {{ $dossier->adherant->nomPrenomscasdebesoin ?? '' }}<br>
            {{ $dossier->adherant->contactPersonnecasdebesoin ?? '' }}
        </div>

        <!-- QR CODE FIX FINAL -->

        @php
        use SimpleSoftwareIO\QrCode\Facades\QrCode;

        $numero = $dossier->adherant->carte->numero_carte ?? 'TEST';
        $url = route('carte.verification', $numero);

        $qr = base64_encode(
        QrCode::format('png')->size(90)->generate($url)
        );
        @endphp

        <div class="qr">
            <img src="data:image/png;base64,{{ $qr }}">
        </div>
    </div>
</body>

</html>