<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin:0; padding:0; }
        .card-verso {
            width: 320px; height: 200px;
            border-radius: 12px; overflow: hidden;
            background: #f8f9fa; color:#000; padding:10px; position:relative;
        }
        .title { text-align:center; font-weight:bold; font-size:12px; color:#007bff; margin-bottom:6px; }
        .section { margin-bottom:8px; font-size:9px; }
        .section-title { font-weight:bold; text-decoration:underline; margin-bottom:3px; }
        .qr { position:absolute; bottom:10px; right:10px; width:60px; height:60px; }
        .qr img { width:100%; height:100%; }
    </style>
</head>
<body>
<div class="card-verso">
    <div class="title">INFORMATIONS IMPORTANTES</div>

    <div class="section">
        <div class="section-title">En cas d'urgence :</div>
        <p>
            📞 {{ config('mutuelle.contact_urgence') }}<br>
            📞 {{ config('mutuelle.assistance') }} (Assistance Mutuelle)<br>
            📍 Centre Médical Partenaire : {{ config('mutuelle.centre_partenaire') }}
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
        <img src="{{ storage_url($qrPath) }}">
    </div>
</div>
</body>
</html>
