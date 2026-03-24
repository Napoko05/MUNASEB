<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🔥 Étape 1 : supprimer si existe
        Schema::table('adherant', function (Blueprint $table) {

            if (Schema::hasColumn('adherant', 'code_unique')) {
                $table->dropColumn('code_unique');
            }

            if (Schema::hasColumn('adherant', 'statut')) {
                $table->dropColumn('statut');
            }

            if (Schema::hasColumn('adherant', 'date_soumission')) {
                $table->dropColumn('date_soumission');
            }
        });

        // 🔥 Étape 2 : recréer proprement
        Schema::table('adherant', function (Blueprint $table) {

            $table->string('code_unique')->nullable()->after('email');
            $table->string('statut')->nullable()->after('code_unique');
            $table->timestamp('date_soumission')->nullable()->after('statut');

        });
    }

    public function down(): void
    {
        Schema::table('adherant', function (Blueprint $table) {

            $table->dropColumn([
                'code_unique',
                'statut',
                'date_soumission'
            ]);

        });
    }
};