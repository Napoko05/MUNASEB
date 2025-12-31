<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cartes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherant_id')->constrained('adherant')->onDelete('cascade');
            $table->string('numero_carte')->unique();
            $table->date('date_effet');
            $table->date('date_validite');
            $table->string('qr_code_path')->nullable();
            $table->string('signature_directeur')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cartes');
    }
};
