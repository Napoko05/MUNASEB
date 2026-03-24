<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {

            $table->id();

            // Relation avec users
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Informations personnelles
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('num_cnib')->nullable()->unique();
            $table->string('service')->nullable();
            $table->string('tel')->nullable();
            $table->string('ville')->nullable();
            
            $table->string('specialite')->nullable();

            // Fichiers justificatifs
            $table->string('cnib_file')->nullable();
            $table->string('attestation_travail_file')->nullable();
            $table->string('diplome_file')->nullable();
            $table->string('signature_file')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
