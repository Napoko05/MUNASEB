<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adherant', function (Blueprint $table) {
            $table->date('date_validite')->nullable();
            $table->string('signature_directeur')->nullable(); // chemin du fichier image
        });
    }

    public function down(): void
    {
        Schema::table('adherant', function (Blueprint $table) {
            $table->dropColumn(['date_validite', 'signature_directeur']);
        });
    }
};
