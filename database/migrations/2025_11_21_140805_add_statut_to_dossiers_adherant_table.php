<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente')->after('document_recu');
        });
    }

    public function down(): void
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};
