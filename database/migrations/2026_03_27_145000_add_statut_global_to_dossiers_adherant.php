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
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->string('statut_global')->default('en_attente')->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->dropColumn('statut_global');
        });
    }
};
