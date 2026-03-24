<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adherent_visas', function (Blueprint $table) {
            $table->id();

            // 🔹 Référence à l'adhérent, enfant ou conjoint
            $table->unsignedBigInteger('adherant_id');

            // 🔹 Type : parent / enfant / conjoint
            $table->enum('type', ['parent', 'enfant', 'conjoint'])->default('parent');

            // 🔹 Étape du workflow : regie_recette / liquidation / directeur
            $table->string('etape');

            // 🔹 Décision : en_attente / valide / rejete
            $table->enum('decision', ['en_attente', 'valide', 'rejete'])->default('en_attente');

            // 🔹 Optionnel : ID de l'utilisateur qui a validé/rejeté
            $table->unsignedBigInteger('user_id')->nullable();

            // 🔹 Motif de rejet (nullable)
            $table->text('motif_rejet')->nullable();

            // 🔹 Commentaire libre
            $table->text('commentaire')->nullable();

            $table->timestamps();

            // 🔗 Clés étrangères
            $table->foreign('adherant_id')
                  ->references('id')->on('adherant')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            // 🔹 Index pour recherche rapide
            $table->index(['adherant_id', 'type', 'etape', 'decision']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adherent_visas');
    }
};