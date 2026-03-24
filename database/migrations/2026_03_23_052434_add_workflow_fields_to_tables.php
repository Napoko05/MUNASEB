<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'dossiers_adherant',
            'cartes',
            'adhesions'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {

                // REGIE
                $table->boolean('regie_valide')->default(false);
                $table->string('regie_visa')->nullable();

                // LIQUIDATION
               
                $table->string('liquidation_visa')->nullable();

                // DIRECTEUR
                $table->boolean('directeur_valide')->default(false);
                $table->string('directeur_visa')->nullable();
            });
        }
    }

    public function down()
    {
        $tables = [
            'dossiers_adherant',
            'cartes',
            'adhesions'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn([
                    'regie_valide',
                    'regie_visa',
                    'liquidation_valide',
                    'liquidation_visa',
                    'directeur_valide',
                    'directeur_visa'
                ]);
            });
        }
    }
};