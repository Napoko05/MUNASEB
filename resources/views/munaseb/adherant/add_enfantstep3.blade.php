@extends('layouts.app')

@section('title', 'Adhésion Étudiant - Step 3')

@section('content')
<div class="container-fluid p-0">
    <div class="bg-light vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="w-100" style="max-width: 900px;">
            <!-- Progress bar -->
            <div class="progress mb-4" style="height: 25px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    Étape 3 sur 3
                </div>
            </div>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <h2 class="fw-bold mb-0">Étape 3 : Upload des documents</h2>
                    <p class="mb-0">Téléchargez vos documents justificatifs</p>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('munaseb.adherant.postEnfantStep3') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Documents Parent --}}
                        <h5 class="mb-3">Documents Parent</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">CNIB ou Passeport (PDF)</label>
                            <input type="file" name="doc_cni" accept=".pdf" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Carte Munaseb (PDF)</label>
                            <input type="file" name="doc_carte_munaseb" accept=".pdf" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reçu de paiement (PDF)</label>
                            <input type="file" name="doc_recu" accept=".pdf" class="form-control" required>
                        </div>

                        {{-- Documents Enfant --}}
                        <h5 class="mb-3">Documents Enfant</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Extrait de naissance (PDF)</label>
                            <input type="file" name="doc_extrait_naissance" accept=".pdf" class="form-control" required>
                        </div>

                        {{-- Documents Conjoint (optionnel) --}}
                        <h5 class="mb-3">Documents Conjoint (optionnel)</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Justificatif Conjoint (PDF)</label>
                            <input type="file" name="doc_conjoint" accept=".pdf" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('munaseb.adherant.adhesionstep2') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Précédent
                            </a>
                            <button type="submit" class="btn btn-success">
                                Soumettre <i class="fa fa-check ms-1"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
