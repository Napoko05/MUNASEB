@extends('layouts.regie')

@section('title', 'Adhérents en attente')

@section('content')
<div class="nonvalide-content-area">

    {{-- ALERTES --}}
    {{-- Message succès --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Message erreur / rejet --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif


    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="nonvalide-card">
        <div class="nonvalide-card-header bg-warning text-dark">
            Adhérents en attente
        </div>

        <div class="table-responsive p-3">
            <table class="nonvalide-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($enAttente as $adherant)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $adherant->nom }}</td>
                        <td>{{ $adherant->prenom }}</td>

                        <td>
                            <span class="nonvalide-badge-warning">En attente</span>
                        </td>

                        <td>
                            {{-- DETAIL --}}
                            <a href="{{ route('regie.adherant.detail', $adherant->id) }}"
                                class="nonvalide-btn-detail">📄 voir</a>

                            @if($adherant->canAct)

                            {{-- VALIDER --}}
                            <form action="{{ route('regie.adherant.valider', $adherant->id) }}"
                                method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="nonvalide-btn-success">
                                    ✔ valider
                                </button>
                            </form>

                            {{-- REJETER --}}
                            <button type="button"
                                class="nonvalide-btn-danger btn-show-reject"
                                data-id="{{ $adherant->id }}">
                                ❌ rejeter
                            </button>

                            {{-- FORMULAIRE CACHE --}}
                            <form action="{{ route('regie.adherant.rejeter', $adherant->id) }}"
                                method="POST"
                                class="motif-rejet-container"
                                id="reject-form-{{ $adherant->id }}">
                                @csrf

                                <textarea name="motif_rejet"
                                    class="form-control mt-2"
                                    placeholder="Motif du rejet..."
                                    required></textarea>

                                <button type="submit"
                                    class="btn btn-danger btn-sm mt-1">
                                    Confirmer
                                </button>
                            </form>

                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Aucun dossier</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.btn-show-reject').forEach(btn => {

            btn.addEventListener('click', function() {

                let id = this.dataset.id;

                // fermer tous les autres
                document.querySelectorAll('.motif-rejet-container').forEach(f => {
                    if (f.id !== 'reject-form-' + id) {
                        f.classList.remove('show');
                    }
                });

                // toggle
                let form = document.getElementById('reject-form-' + id);
                form.classList.toggle('show');

            });

        });

    });
</script>
@endsection