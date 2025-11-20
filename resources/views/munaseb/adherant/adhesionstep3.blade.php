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
                    <form action="{{ route('munaseb.adherant.postParentStep3') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- CNIB ou Passeport --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">CNIB ou Passeport (PDF)</label>
                            <input type="file" name="document_cni" accept=".pdf" class="form-control" required>
                        </div>

                        {{-- Attestation --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Attestation d'inscription (PDF)</label>
                            <input type="file" name="document_attestation" accept=".pdf" class="form-control" required>
                        </div>

                        {{-- Reçu de paiement --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reçu de paiement (PDF)</label>
                            <input type="file" name="document_recu" accept=".pdf" class="form-control" required>
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
