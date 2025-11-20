@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h2 class="mb-3 text-primary">📜 Historique de mes paiements</h2>
            <p>Bienvenue, <strong>{{ $user->name }}</strong> !</p>
            <hr>

            {{-- SECTION COTISATIONS --}}
            <h4 class="text-success mb-3">💰 Paiements de cotisation</h4>
            @if(count($cotisations) > 0)
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cotisations as $cotisation)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($cotisation['date'])->format('d/m/Y') }}</td>
                                <td>{{ number_format($cotisation['montant'], 0, ',', ' ') }} FCFA</td>
                                <td><span class="badge bg-success">{{ $cotisation['statut'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Aucun paiement enregistré.</p>
            @endif

            <hr>

            {{-- SECTION REMBOURSEMENTS --}}
            <h4 class="text-info mb-3">🔁 Remboursements effectués</h4>
            @if(count($remboursements) > 0)
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($remboursements as $remboursement)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($remboursement['date'])->format('d/m/Y') }}</td>
                                <td>{{ number_format($remboursement['montant'], 0, ',', ' ') }} FCFA</td>
                                <td><span class="badge bg-primary">{{ $remboursement['statut'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Aucun remboursement pour le moment.</p>
            @endif
        </div>
    </div>
</div>
@endsection
