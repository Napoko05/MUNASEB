<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('add_enfants', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté pour l'enfant

            // Clé étrangère vers le parent
            $table->foreignId('parent_id')
                  ->constrained('adherant') // référence la table des parents
                  ->onDelete('cascade');    // suppression en cascade

            // Informations de l'enfant
            $table->string('ine')->nullable(); // optionnel
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('dateNaiss');
            $table->string('lieuNaiss');
            $table->string('avatar')->nullable();

            // Étape 2 : infos documents et contacts
            $table->string('typedoc')->nullable();
            $table->string('typedoc_parent')->nullable();
            $table->string('numdoc')->nullable();
            $table->string('numero')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('email')->nullable();

            // Étape 3 : fichiers justificatifs
            $table->string('doc_cni')->nullable();
            $table->string('doc_attestation')->nullable();
            $table->string('doc_recu')->nullable();
            $table->string('doc_carte_parent')->nullable();

            $table->timestamps();

            // Index unique pour éviter qu'un même enfant soit enregistré deux fois pour le même parent
            $table->unique(['parent_id', 'nom', 'prenom', 'dateNaiss'], 'unique_parent_enfant');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('add_enfants');
    }
};
