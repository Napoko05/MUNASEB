@extends('layouts.app_adherent')

@section('title', 'Adhésion Étudiant - Step 3')

@section('content')

<style>

/* ===============================
   VARIABLES CIMAF
================================ */
:root {
  --cimaf-blue: #0B4DA2;
  --cimaf-orange: #F58220;
  --cimaf-red: #D32F2F;
  --cimaf-gray-light: #F5F5F5;
}

/* ===============================
   CONTENEUR GLOBAL
================================ */
.container-center {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: var(--cimaf-gray-light);
  padding: 20px;
}

/* ===============================
   CARTE
================================ */
.register-card {
  width: 100%;
  max-width: 700px;
  background: #fff;
  border-radius: 14px;
  padding: 35px;
  border: 2px solid var(--cimaf-red);
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* ===============================
   HEADER
================================ */
.step-header {
  background: var(--cimaf-orange);
  color: #fff;
  padding: 18px;
  border-radius: 12px 12px 0 0;
  margin: -35px -35px 30px;
  text-align: center;
}

.step-header h2 {
  font-size: 1.4rem;
  font-weight: 600;
}

/* ===============================
   PROGRESS BAR
================================ */
.progress {
  height: 22px;
  border-radius: 12px;
}

.progress-bar {
  background: var(--cimaf-blue);
  font-weight: 600;
}

/* ===============================
   FORM GROUP
================================ */
.mb-3 {
  margin-bottom: 22px;
}

.mb-3 label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  font-size: 16px;
}

/* ===============================
   INPUT FILE
================================ */
.mb-3 input {
  width: 100%;
  border-radius: 10px;
  padding: 11px 14px;
  border: 1px solid #ccc;
  font-size: 15px;
  transition: all .25s;
}

.mb-3 input:focus {
  border-color: var(--cimaf-orange);
  box-shadow: 0 0 0 .15rem rgba(245,130,32,.25);
  outline: none;
}

/* ===============================
   BOUTONS
================================ */
.form-buttons{
  display:flex;
  gap:20px;
  margin-top:35px;
}

.form-buttons .btn{
  flex:1;
  padding:13px;
  font-size:16px;
  font-weight:600;
  border-radius:10px;
}

/* bouton retour */
.btn-retour{
  background:#fff;
  border:2px solid #ccc;
}

/* bouton enregistrer */
.btn-save{
  background:var(--cimaf-orange);
  border:none;
  color:#fff;
}

.btn-save:hover{
  background:#d96f1c;
}

/* ===============================
   RESPONSIVE
================================ */
@media(max-width:768px){

.form-buttons{
flex-direction:column;
}

}

</style>

<div class="container-center">

<div class="register-card">

<!-- Progress -->
<div class="progress mb-4">
<div class="progress-bar" style="width:100%">
Étape 3 sur 3
</div>
</div>

<div class="step-header">
<h2>Étape 3 : Upload des documents</h2>
<p>Téléchargez vos documents justificatifs</p>
</div>

<form action="{{ route('munaseb.adherant.postParentStep3') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- CNIB --}}
<div class="mb-3">
<label>CNIB ou Passeport (PDF)</label>
<input type="file" name="document_cni" accept=".pdf" required>
</div>

{{-- Attestation --}}
<div class="mb-3">
<label>Attestation d'inscription (PDF)</label>
<input type="file" name="document_attestation" accept=".pdf" required>
</div>

{{-- Reçu --}}
<div class="mb-3">
<label>Reçu de paiement (PDF)</label>
<input type="file" name="document_recu" accept=".pdf" required>
</div>

<!-- Boutons -->
<div class="form-buttons">

<a href="{{ route('munaseb.adherant.adhesionstep2') }}" class="btn btn-retour">
← Retour
</a>

<button type="submit" class="btn btn-save">
Enregistrer ✓
</button>

</div>

</form>

</div>
</div>

@endsection