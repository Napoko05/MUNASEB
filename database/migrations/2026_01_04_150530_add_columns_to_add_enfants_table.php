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
        Schema::table('add_enfants', function (Blueprint $table) {
            $table->string('code_unique')->unique();
            $table->string('statut')->default('En attente');
            $table->timestamp('date_soumission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('add_enfants', function (Blueprint $table) {
            $table->dropColumn(['code_unique', 'statut', 'date_soumission']);
        });
    }
};
