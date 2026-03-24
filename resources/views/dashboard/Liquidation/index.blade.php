@extends('layouts.liquidation_app')

@section('content')

<div class="dashboard-container">

    <div class="dashboard-card">

        <div class="dashboard-header">
            <h4>{{ $titre ?? 'Tableau de bord' }}</h4>
        </div>

        <div class="dashboard-body">

            {{-- ALERTES --}}
            @if(session('success'))
                <div class="alert alert-success custom-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger custom-alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-wrapper">
                <table class="custom-table">

                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Motif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($dossiers as $dossier)
                        <tr>

                            <td>{{ $dossier->adherant->nom ?? 'N/A' }}</td>
                            <td>{{ $dossier->adherant->prenom ?? 'N/A' }}</td>
                            <td>{{ ucfirst($dossier->type) }}</td>

                            <td>
                                @if($dossier->liquidation_valide)
                                    <span class="badge success">Carte créée</span>
                                @elseif($dossier->statut == 'rejete')
                                    <span class="badge danger">Rejeté</span>
                                @else
                                    <span class="badge warning">En attente</span>
                                @endif
                            </td>

                            <td class="motif">
                                {{ $dossier->statut == 'rejete' ? $dossier->motif_rejet : '---' }}
                            </td>

                            <td>
                                <div class="actions">

                                    <a href="{{ route('liquidation.dossier.voirDocument', $dossier->id) }}"
                                       class="btn info">Détail</a>

                                    @if(!$dossier->liquidation_valide && $dossier->statut != 'rejete')

                                    <form method="POST"
                                          action="{{ route('liquidation.creerCarte', $dossier->id) }}">
                                        @csrf
                                        <button class="btn success">Créer</button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('liquidation.rejeter', $dossier->id) }}"
                                          class="reject-form"
                                          id="form-{{ $dossier->id }}">
                                        @csrf

                                        <textarea name="motif_rejet"
                                                  placeholder="Motif..."
                                                  class="reject-input"></textarea>

                                        <button type="button"
                                                class="btn danger toggle-btn"
                                                data-id="{{ $dossier->id }}">
                                            Rejeter
                                        </button>

                                        <button type="submit"
                                                class="btn danger confirm-btn">
                                            OK
                                        </button>
                                    </form>

                                    @else
                                        <span class="no-action">—</span>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty">Aucun dossier</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        let form = document.getElementById('form-' + this.dataset.id);
        form.classList.toggle('active');
    });
});
</script>
@endsection