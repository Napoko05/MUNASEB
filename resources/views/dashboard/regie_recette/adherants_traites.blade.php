@extends('layouts.regie')

@section('title', 'Adhérents traités')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">

            {{-- ALERTES --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- =======================
                TABLEAU VALIDÉS
            ======================= --}}
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-success text-white">
                    ✔️ Adhérents validés
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            
                                <thead class="table-dark">
                                    <tr>
                                        <th>INE</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            <tbody>
                                @forelse($traitees->where('visaDecision', 'valide') as $adherant)
                                <tr>
                                    <td>{{ $adherant->ine }}</td>
                                    <td>{{ $adherant->nom }}</td>
                                    <td>{{ $adherant->prenom }}</td>

                                    <td>
                                        <span class="badge bg-success">✔ Validé</span>
                                    </td>

                                    <td>
                                        <a href="{{ route('regie.adherant.detail', $adherant->id) }}"
                                            class="btn btn-sm btn-info">
                                            📄 Détail
                                        </a>

                                        @if($adherant->canModify ?? false)
                                        <a href="{{ route('regie.adherant.modifier', $adherant->id) }}"
                                            class="btn btn-sm btn-warning">
                                            ✏️ Modifier
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Aucun adhérent validé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- =======================
                TABLEAU REJETÉS
            ======================= --}}
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white">
                    ❌ Adhérents rejetés
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>INE</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($traitees->where('visaDecision', 'rejete') as $adherant)
                                <tr>
                                    <td>{{ $adherant->ine }}</td>
                                    <td>{{ $adherant->nom }}</td>
                                    <td>{{ $adherant->prenom }}</td>

                                    <td class="text-danger fw-semibold">
                                        {{ $adherant->dossier->motif_rejet ?? '---' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-danger">✖ Rejeté</span>
                                    </td>

                                    <td>
                                        <a href="{{ route('regie.adherant.detail', $adherant->id) }}"
                                            class="btn btn-sm btn-info">
                                            📄 Détail
                                        </a>

                                        @if($adherant->canModify ?? false)
                                        <a href="{{ route('regie.adherant.modifier', $adherant->id) }}"
                                            class="btn btn-sm btn-warning">
                                            ✏️ Modifier
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">Aucun adhérent rejeté</td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection