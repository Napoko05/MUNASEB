@extends('layouts.directeur_app')

@section('content')

<div class="card border-0 shadow-lg rounded-4">

    <div class="card-header text-white" style="background: linear-gradient(90deg, #007bff, #6610f2);">
        <h4 class="mb-0 fw-bold text-center">
            {{ $titre ?? 'Cartes à signer' }}
        </h4>
    </div>

    <div class="card-body bg-light">

        <div class="table-responsive">
            <table class="table align-middle table-hover text-center">

                <thead class="table-primary">
                    <tr>
                        <th>INE</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro carte</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($carte as $carte)
                    <tr>
                        <td>{{ $carte->adherant->ine ?? '---' }}</td>
                        <td>{{ $carte->adherant->nom ?? 'N/A' }}</td>
                        <td>{{ $carte->adherant->prenom ?? 'N/A' }}</td>
                        <td>{{ $carte->numero }}</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                ⏳ En attente de signature
                            </span>
                        </td>

                        <td>

                            {{-- DETAIL --}}
                            <a href="{{ route('directeur.dossier.detail', $carte->adherant->id) }}"
                               class="btn btn-sm btn-info">
                               📄 Détail
                            </a>

                            {{-- SIGNER --}}
                            @if(!$carte->directeur_valide)
                            <form action="{{ route('directeur.carte.signer', $carte->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">
                                    ✔ Signer
                                </button>
                            </form>
                            @endif

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Aucune carte à signer
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection