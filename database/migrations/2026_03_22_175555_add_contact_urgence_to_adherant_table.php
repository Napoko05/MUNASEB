<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adherant', function (Blueprint $table) {
            $table->string('nomPrenomscasdebesoin')->nullable()->after('idFiliere');
            $table->string('contactPersonnecasdebesoin')->nullable()->after('nomPrenomscasdebesoin');
            $table->string('lienPersonnecasdebesoin')->nullable()->after('contactPersonnecasdebesoin');
        });
    }

    public function down(): void
    {
        Schema::table('adherant', function (Blueprint $table) {
            $table->dropColumn([
                'nomPrenomscasdebesoin',
                'contactPersonnecasdebesoin',
                'lienPersonnecasdebesoin'
            ]);
        });
    }
};