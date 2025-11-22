@extends('layouts.app')

@section('content')
<style>
    /* ----- SIDEBAR FIXE ----- */
    .sidebar {
        position: fixed;
        top: 90px;                   /* hauteur du navbar si tu en as un */
        left: 0;
        width: 240px;
        height: calc(100vh - 70px);
        overflow-y: auto;
        background: #0b3cc4ff;
        border-right: 2px solid #ddd;
        padding-bottom: 50px;
        z-index: 1000;
    }

    .sidebar .list-group-item {
        border: none;
        padding: 15px 20px;
        font-size: 15px;
    }

    .sidebar .list-group-item:hover {
        background: #eaeef5ff;
        cursor: pointer;
    }

    /* ----- CONTENU À DROITE ----- */
    .content-area {
        margin-left: 250px;
        padding: 20px;
    }
</style>

{{-- ===================== --}}
{{-- SIDEBAR STATIQUE      --}}
{{-- ===================== --}}
<div class="sidebar shadow-sm">
    <div class="fw-bold text-primary px-3 py-3 fs-5">
        📁 Menu Régie
    </div>

    <ul class="list-group list-group-flush">

        <li class="list-group-item fw-semibold">
            🟡 Cartes non traitées
        </li>

        <li class="list-group-item fw-semibold">
            🟢 Cartes traitées
        </li>

        <li class="list-group-item fw-semibold">
            📊 Statistiques
        </li>
         <li class="list-group-item fw-semibold">
            📊 profil
        </li>


        <li class="list-group-item fw-semibold">
            ⚙ Paramètres
        </li>

    </ul>
</div>


{{-- ===================== --}}
{{-- CONTENU DE DROITE     --}}
{{-- ===================== --}}
<div class="content-area">

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-gradient text-white" 
             style="background: linear-gradient(90deg, #007bff, #6610f2);">
            <h4 class="mb-0 fw-bold">📋 Exemple de contenu</h4>
        </div>

        <div class="card-body bg-light">
            <p>
                
              

            <hr>

            {{-- Exemple de table statique --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Numéro carte</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>CARTE-00123</td>
                            <td>Ouédraogo</td>
                            <td>Issa</td>
                            <td><span class="badge bg-warning text-dark">Non traitée</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">📄 Détail</button>
                                <button class="btn btn-sm btn-success">✔ Valider</button>
                            </td>
                        </tr>

                        <tr>
                            <td>CARTE-00251</td>
                            <td>Sanou</td>
                            <td>Mariam</td>
                            <td><span class="badge bg-success">Traitée</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning text-white">✏ Modifier</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection
