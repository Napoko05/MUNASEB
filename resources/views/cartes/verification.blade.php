<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vérification Carte Mutualiste</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            text-align: center;
            padding: 40px;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            padding: 25px;
            width: 380px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #2e7d32;
        }

        .info {
            text-align: left;
            font-size: 14px;
            line-height: 1.6;
        }

        .info p {
            margin: 6px 0;
        }

        .status-ok {
            color: green;
            font-weight: bold;
        }

        .status-bad {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #777;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .valid {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .invalid {
            background: #ffebee;
            color: #c62828;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Carte Mutualiste MUNASEB</h2>

    <div class="info">

        <p><strong>Nom :</strong> {{ $carte->adherant->nom ?? '' }}</p>
        <p><strong>Prénom :</strong> {{ $carte->adherant->prenom ?? '' }}</p>
        <p><strong>Matricule :</strong> {{ $carte->adherant->matricule ?? '' }}</p>

        <p><strong>Université :</strong> {{ $carte->adherant->dossier->universite->nom ?? '' }}</p>
        <p><strong>Filière :</strong> {{ $carte->adherant->dossier->filiere->nom ?? '' }}</p>

        <hr>

        <p><strong>Date de validité :</strong>
            {{ $carte->date_validite
                ? \Carbon\Carbon::parse($carte->date_validite)->format('d/m/Y')
                : 'Non définie' }}
        </p>

        <p><strong>Statut :</strong>
            @if(
                $carte->signature_directeur &&
                $carte->date_validite &&
                $carte->date_validite >= now()->toDateString()
            )
                <span class="badge valid">✔ CARTE VALIDE</span>
            @else
                <span class="badge invalid">✖ CARTE NON VALIDE</span>
            @endif
        </p>

    </div>

    <div class="footer">
        Vérification officielle MUNASEB - Mutuelle des Étudiants
    </div>

</div>

</body>
</html>