<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dossiers_enfants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherant_id')->constrained('adherant')->onDelete('cascade');
            
            // Documents spécifiques à l'enfant
            $table->string('document_extrait_naissance')->nullable();
            $table->string('document_cni_parent')->nullable(); // si besoin pour référence
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers_enfants');
    }
};
