<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin:0; padding:0; }
        .card-recto {
            width: 320px; height: 200px;
            border-radius: 12px; overflow: hidden;
            background: linear-gradient(135deg,#007bff,#00c851);
            color: #fff; padding: 10px; position: relative;
        }
        .photo { width: 80px; height: 100px; float:left; border-radius:8px; overflow:hidden; }
        .photo img { width:100%; height:100%; object-fit:cover; }
        .info { margin-left:100px; font-size:10px; }
        .signature { position:absolute; bottom:10px; left:10px; width:60px; }
        .signature img { width:100%; }
    </style>
</head>
<body>
<div class="card-recto">
    <div class="photo">
        <img src="{{ storage_url('adherant/photo/'.$adherant->photo) }}">
    </div>
    <div class="info">
        <h4>CARTE N° {{ $adherant->numeroCarte }}</h4>
        <p><b>Nom :</b> {{ $adherant->nom }}</p>
        <p><b>Prénoms :</b> {{ $adherant->prenoms }}</p>
        <p><b>Né le :</b> {{ gl_format_date($adherant->dateNaissance) }} à {{ $adherant->lieuNaissance }}</p>
        <p><b>Date effet :</b> {{ gl_format_date($adherant->dateEffet) }} | <b>Validité :</b> {{ gl_format_date($adherant->dateValidite) }}</p>
        <p><b>Université :</b> {{ $adherant->codeUniversite }}</p>
        <p><b>UFR :</b> {{ $adherant->codeFiliere }} - {{ $adherant->codeNiveau }}</p>
        <p><b>Contact :</b> {{ $adherant->tel1 }}</p>
    </div>
    <div class="signature">
        @if($agent && $agent->signature_image)
            <img src="{{ storage_url('agents/signatures/'.$agent->signature_image) }}">
        @endif
    </div>
</div>
</body>
</html>
