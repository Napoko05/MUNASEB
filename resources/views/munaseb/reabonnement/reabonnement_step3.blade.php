@extends('layouts.app')

@section('title', 'Réabonnement - Étape 3')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Étape 3 : Importer vos documents justificatifs</h2>

    <form action="{{ route('munaseb.reabonnement.postStep3') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="mb-3">
            <label>Document CNI</label>
            <input type="file" name="document_cni" class="form-control">
        </div>

        <div class="mb-3">
            <label>Document attestation</label>
            <input type="file" name="document_attestation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Document reçu</label>
            <input type="file" name="document_recu" class="form-control">
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('munaseb.reabonnement.reabonnementStep2') }}" class="btn btn-secondary">← Retour</a>
            <a href="{{ route('dashboard.etudiant') }}" class="btn btn-danger">Annuler</a>
            <button type="submit" class="btn btn-success">Terminer</button>
        </div>
    </form>
</div>
@endsection

