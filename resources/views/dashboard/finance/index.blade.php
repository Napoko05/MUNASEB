@extends('layouts.directeur_app')

@section('content')

<div class="dir-container">

    <div class="dir-card">

        {{-- HEADER --}}
        <div class="dir-header">
            <h4>
                📋 {{ $titre ?? 'Cartes à signer' }}
            </h4>
        </div>

        {{-- BODY --}}
        <div class="dir-body">

            <div class="dir-table-wrapper">

                <table class="dir-table">

                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>INE</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>N° Carte</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($cartes as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $item->adherant->ine ?? '---' }}</td>
                            <td>{{ $item->adherant->nom ?? 'N/A' }}</td>
                            <td>{{ $item->adherant->prenom ?? 'N/A' }}</td>

                            <td class="card-number">{{ $item->numero }}</td>

                            <td>
                                <span class="badge warning">
                                    ⏳ En attente
                                </span>
                            </td>

                            <td class="d-flex gap-2">
                                <a href="{{ route('directeur.dossier.detail', $item->adherant->id) }}"class="btn btn-sm btn-primary">
                                    👁️ Voir
                                </a>

                                <a href="{{ route('directeur.carte.signer', $item->id) }}" class="btn btn-sm btn-success">
                                    ✍️ Signer
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Aucune carte disponible
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