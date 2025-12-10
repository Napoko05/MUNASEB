@extends('layouts.app')

@section('content')

<div class="sidebar shadow-sm">
    <h4 class="fw-bold">Directeur de la MUNASEB</h4>

    <a href="{{ route('directeur.dashboard') }}">Accueil</a>
    <a href="#">Agents</a>

    <!-- Cartes -->
    <a data-bs-toggle="collapse"
        href="#cartesSubmenu"
        role="button"
        aria-expanded="false"
        aria-controls="cartesSubmenu">
        Cartes
    </a>

    <div class="collapse submenu" id="cartesSubmenu">
        <a href="{{ route('directeur.cartes.traiter') }}" class="btn btn-sm btn-primary">
            Créer sa carte
        </a>



        <a href="#">Liste Cartes</a>
    </div>

    <a href="#">Statistiques</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="content-area">

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header text-white"
            style="background: linear-gradient(90deg, #007bff, #6610f2);">
            <h4 class="mb-0 fw-bold text-center">
                {{ $titre ?? 'Tableau de bord' }}
            </h4>
        </div>

        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dossiers as $dossier)
                        <tr>
                            <td>{{ $dossier->adherant->nom }}</td>
                            <td>{{ $dossier->adherant->prenom }}</td>
                            <td class="text-center">
                                @if($dossier->statut === 'en_attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                                @elseif($dossier->statut === 'valide')
                                <span class="badge bg-success">Validé</span>
                                @elseif($dossier->statut === 'rejete')
                                <span class="badge bg-danger">Rejeté</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('directeur.adhesion.detail', $dossier->id) }}"
                                    class="btn btn-info btn-sm">Voir profil</a>

                                @if($dossier->statut === 'valide')
                                <a href="{{ route('directeur.adherants.creer_carte', $dossier->id) }}"
                                    class="btn btn-success btn-sm">Créer carte</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Aucun dossier trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection