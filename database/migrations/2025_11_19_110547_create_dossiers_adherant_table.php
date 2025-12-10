<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dossiers_adherant', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation vers la table adherants
            $table->foreignId('adherant_id')
                  ->constrained('adherant')
                  ->cascadeOnDelete();

            $table->string('photo')->nullable();
            $table->string('document_cni')->nullable();
            $table->string('document_attestation')->nullable();
            $table->string('document_recu')->nullable();

            // 🟢 Ajout direct du statut
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])
                  ->default('en_attente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers_adherant');
    }
};
