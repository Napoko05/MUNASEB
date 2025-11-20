<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifie si la table existe déjà
        if (!Schema::hasTable('filieres')) {

            Schema::create('filieres', function (Blueprint $table) {
                $table->id();

                // clé étrangère vers universites
                $table->foreignId('idUniversite')
                    ->constrained('universites')
                    ->cascadeOnDelete();

                // nom de la filière
                $table->string('nom');

                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
