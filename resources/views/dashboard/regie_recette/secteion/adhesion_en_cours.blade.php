@extends('dashboard.regie_recette.index')

@section('section_title', 'Nouvelles adhésions en cours')

@section('section_content')
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Date de demande</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adhesions as $adhesion)
                    <tr>
                        <td>{{ $adhesion->nom }} {{ $adhesion->prenom }}</td>
                        <td>{{ $adhesion->email }}</td>
                        <td>{{ $adhesion->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">👁️ Détails</a>
                            <a href="#" class="btn btn-sm btn-success">✔️ Traiter</a>
                            <a href="#" class="btn btn-sm btn-danger">❌ Rejeter</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Aucune adhésion en attente</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
