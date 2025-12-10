@extends('layouts.app')

@section('content')

<div class="sidebar shadow-sm">
    <h4 class="fw-bold">Régie Recette</h4>

    <a href="" {{ route('regie.dashboard') }}""> Accueil</a>

    <!-- Adhésions -->
    <a data-bs-toggle="collapse" href="#adhesionsSubmenu" role="button" aria-expanded="false" aria-controls="adhesionsSubmenu">
         Adhésions non traitées
    </a>
    <div class="collapse submenu" id="adhesionsSubmenu">
        <a href="{{ route('regie.adherants.non_valide') }}">Adhérents</a>
        <a href="{{ route('regie.enfants.non_valide') }}"> Enfants</a>
        <a href="{{ route('regie.conjoints.non_valide') }}"> Conjoints</a>
    </div>

    <a href="{{ route('regie.adherants.traitees') }}"> Adhésions traitées</a>


    <a href="#">Statistiques</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">Déconnexion</button>
    </form>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="content-area">

    {{-- Tableau dynamique selon type --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-blue text-white" style="background: linear-gradient(90deg, #007bff, #6610f2);">
            <h4 class="mb-0 fw-bold text-center">{{ $titre ?? ' Tableau de bord' }}</h4>
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
                            <td>{{ $dossier->adherant?->nom ?? 'Non défini' }}</td>
                            <td>{{ $dossier->adherant?->prenom ?? 'Non défini' }}</td>
                            <td class="text-center">
                                @if($dossier->statut === 'en_attente')
                                <span class="badge bg-warning text-dark">Non validée</span>
                                @elseif($dossier->statut === 'valide')
                                <span class="badge bg-success">Validée</span>
                                @elseif($dossier->statut === 'rejete')
                                <span class="badge bg-danger">Rejetée</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($dossier->statut === 'en_attente')
                                <a href="{{ route('regie.adherant.detail', $dossier->id) }}" class="btn btn-sm btn-outline-primary me-2">📄 Détail</a>
                                <a href="{{ route('regie.adherant.valider', $dossier->id) }}" class="btn btn-sm btn-success me-1"> Valider</a>
                                <a href="{{ route('regie.adherant.rejeter', $dossier->id) }}" class="btn btn-sm btn-danger"> Rejeter</a>
                                @else
                                <a href="{{ route('adherant.detail', $dossier->id) }}" class="btn btn-sm btn-warning text-white">Modifier</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aucun dossier trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
@endsection