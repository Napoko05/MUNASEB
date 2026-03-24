<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table enfants
        Schema::create('add_enfants', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers le parent
            $table->foreignId('parent_id')
                  ->constrained('adherant')
                  ->cascadeOnDelete();

            // Informations enfant
            $table->string('ine')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('dateNaiss');
            $table->string('lieuNaiss');
            $table->string('avatar')->nullable();

            // Documents et contacts
            $table->string('typedoc')->nullable();
            $table->string('numdoc')->nullable();
            $table->string('tel1')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();

            // Empêcher doublon enfant pour un parent
            $table->unique(
                ['parent_id', 'nom', 'prenom', 'dateNaiss'],
                'unique_parent_enfant'
            );
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers_enfants');
        Schema::dropIfExists('add_enfants');
    }
};