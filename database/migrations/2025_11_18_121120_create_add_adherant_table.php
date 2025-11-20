<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adherant', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté pour clé primaire
            $table->string('ine')->unique(); // INE unique pour empêcher double inscription

            // Step 1 : identité
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->date('dateNaiss')->nullable();
            $table->string('lieuNaiss')->nullable();

            // Step 2 : académique / contact
            $table->string('typedoc')->nullable();
            $table->string('numdoc')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('idUniversite')->nullable()->constrained('universites')->nullOnDelete();
            $table->foreignId('idFiliere')->nullable()->constrained('filieres')->nullOnDelete();

            // Photo et typage
            $table->string('photo')->nullable();
            $table->enum('type_adherant', ['etudiant', 'ayant_droit']);

            // Step 3 : documents justificatifs
            $table->string('document_cni')->nullable();
            $table->string('document_attestation')->nullable();
            $table->string('document_recu')->nullable();

            // Infos d’adhésion
            $table->string('numero_adhesion')->nullable()->unique();
            $table->date('date_adhesion')->nullable();
            $table->text('commentaire')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adherant');
    }
};
