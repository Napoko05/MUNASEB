@extends('layouts.app')

@section('content')
<div class="agent-page">
    <h2 class="agent-main-title">Créer un nouvel agent - Étape 2 : Récapitulatif & Justificatifs</h2>

    <form class="agent-form" action="{{ route('admin.agents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Récapitulatif --}}
        <h5>Récapitulatif :</h5>
        <div class="card p-3 mb-3 shadow-sm">
            @foreach($data as $key => $value)
            @if(!in_array($key, ['cnib_file','attestation_travail_file','diplome_file','signature_file','role']))
            <div class="agent-field mb-2">
                <strong>{{ ucfirst($key) }} :</strong> {{ $value }}
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            </div>
            @endif
            @endforeach
        </div>

        {{-- Sélection rôle --}}
        <div class="agent-field mb-3">
            <label><strong>Rôle</strong></label>
            <select name="role" required>
                <option value="">Sélectionner un rôle</option>
                @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ (isset($data['role']) && $data['role'] == $role->name) ? 'selected' : '' }}>
                    {{ ucfirst($role->name) }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Upload fichiers --}}
        <h5>Fichiers justificatifs :</h5>
        @foreach([
        'cnib_file' => 'CNIB',
        'attestation_travail_file' => 'Attestation de travail',
        'diplome_file' => 'Diplôme / Attestation spécialité',
        'signature_file' => 'Signature'
        ] as $field => $label)

        <div class="agent-field mb-3">
            <label>{{ $label }}</label>

            <!-- Re-upload option -->
            <input type="file" name="{{ $field }}">

            <!-- 🔥 garder ancien fichier -->
            <input type="hidden" name="existing_files[{{ $field }}]" value="{{ $files[$field] ?? '' }}">

            @if(!empty($files[$field]))
            <small class="text-success">
                Déjà uploadé : {{ basename($files[$field]) }}
            </small>
            @endif
        </div>

        @endforeach

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.agents.create') }}" class="agent-btn-back">Retour pour modifier</a>
            <button type="submit" class="agent-btn-submit">Créer l'agent</button>
        </div>

    </form>
</div>
@endsection