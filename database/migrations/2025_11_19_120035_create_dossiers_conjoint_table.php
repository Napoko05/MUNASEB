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
        Schema::create('dossiers_conjoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conjoint_id')->constrained('add_conjoints')->onDelete('cascade');
            $table->string('document_cni')->nullable();
            $table->string('document_acte_mariage')->nullable();
            $table->string('document_recu')->nullable();
            $table->string('document_carte')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers_conjoints');
    }
};
