<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn('sexe');
        });

        Schema::table('agents', function (Blueprint $table) {
            $table->enum('sexe', ['Masculin', 'Féminin'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn('sexe');
            $table->string('sexe', 10)->nullable(); // ou ton ancien type
        });
    }
};