<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('add_conjoints', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers le parent
            $table->foreignId('parent_id')
                  ->constrained('adherant')
                  ->onDelete('cascade');

            // Infos personnelles
            $table->string('ine')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('dateNaiss');
            $table->string('lieuNaiss');
            $table->string('avatar')->nullable();

            // Infos documents et contacts (numéro/typedoc)
            $table->string('typedoc')->nullable();
            $table->string('typedoc_conjoint')->nullable();
            $table->string('numact')->nullable();
            $table->string('numero')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();

            $table->unique(['parent_id', 'nom', 'prenom', 'dateNaiss'], 'unique_conjoint_parent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('add_conjoints');
    }
};
