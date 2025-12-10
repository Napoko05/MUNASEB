<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .card {
            width: 320px;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            padding: 10px;
        }

        /* RECTO */
        .card-recto {
            background: linear-gradient(135deg, #007bff, #00c851);
            color: #fff;
        }

        .photo {
            width: 80px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            position: absolute;
            left: 10px;
            top: 10px;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info {
            position: absolute;
            left: 100px;
            top: 10px;
            right: 10px;
            font-size: 10px;
        }

        /* Conteneur recto */
        .recto {
            position: relative;
            /* permet de placer la signature en absolu */
            width: 100%;
            height: 100%;
        }

        /* Signature collée à droite */
        .recto .signature {
            position: absolute;
            /* se place par rapport au conteneur .recto */
            bottom: 5px;
            /* collée en bas */
            right: 0;
            /* carrément à droite */
        }

        .recto .signature img {
            max-width: 50px;
            /* réduit au maximum la largeur */
            height: auto;
            /* garde les proportions */
        }



        /* VERSO */
        .card-verso {
            background: linear-gradient(135deg, #007bff, #00c851);
            color: #fff;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .section {
            margin-bottom: 8px;
            font-size: 9px;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px;
        }

        .qr {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 60px;
            height: 60px;
        }

        .qr img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>

    {{-- ======================= RECTO ======================= --}}
    <div class="card card-recto">

        <div class="photo">
            <img src="{{ asset('storage/adherant/photo/'.$adherant->photo) }}" alt="Photo Adhérent">
        </div>

        <div class="info">
            <h4>CARTE N° {{ $adherant->numeroCarte }}</h4>
            <p><b>Nom :</b> {{ $adherant->nom }}</p>
            <p><b>Prénoms :</b> {{ $adherant->prenom }}</p>
            <p><b>Né le :</b> {{ \Carbon\Carbon::parse($adherant->dateNaiss)->format('d/m/Y') }} à {{ $adherant->lieuNaiss }}</p>

            <!-- Dates -->
            <p><b>Date d'effet :</b> {{ \Carbon\Carbon::parse($adherant->date_effet)->format('d/m/Y') }}</p>
            <p><b>Date de validité :</b> {{ \Carbon\Carbon::parse($adherant->date_validite)->format('d/m/Y') }}</p>

            <p><b>Université :</b> {{ $adherant->universites->nom }}</p>
            <p><b>Filière :</b> {{ $adherant->filieres->nom }} - {{ $adherant->codeNiveau }}</p>
            <p><b>Contact :</b> {{ $adherant->tel1 }}</p>

            <!-- Signature électronique -->
            @if($adherant->signature_directeur)
            <div class="signature">
                <img src="{{ asset('storage/agents/signatures/' . $adherant->signature_directeur) }}" alt="Signature Directeur">
            </div>
            @endif
        </div>

    </div>

    {{-- ======================= VERSO ======================= --}}
    <div class="card card-verso page-break">

        <div class="title">INFORMATIONS IMPORTANTES</div>

        <div class="section">
            <div class="section-title">En cas d'urgence :</div>
            <p>
                {{ config('mutuelle.contact_urgence') }} <br>
                {{ config('mutuelle.assistance') }} (Assistance Mutuelle)<br>
                Centre Médical Partenaire : {{ config('mutuelle.centre_partenaire') }}
            </p>
        </div>

        <div class="section">
            <div class="section-title">Conditions d’utilisation :</div>
            <p>
                Cette carte est personnelle et incessible.<br>
                Toute falsification expose son auteur à des poursuites.<br>
                Présenter la carte avec une pièce d’identité valide.
            </p>
        </div>

        <div class="qr">
            <img src="{{ asset('storage/'.$qrPath) }}" alt="QR Code">
        </div>
    </div>

</body>

</html>