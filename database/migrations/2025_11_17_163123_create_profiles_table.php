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
        // 🔍 Vérifier si la table existe déjà
        if (Schema::hasTable('profiles')) {
            return; // ⛔ La table existe → on ignore complètement cette migration
        }

        Schema::create('profiles', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->string('libelle')->unique(); // ex: étudiant, ayant_droit, admin

            $table->timestamps();
            $table->softDeletes(); // permet les suppressions logiques
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
