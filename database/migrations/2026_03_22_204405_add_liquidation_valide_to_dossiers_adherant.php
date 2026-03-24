<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** * Run the migrations. */ public function up()
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->boolean('liquidation_valide')->default(false);
        });
    }
    public function down()
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->dropColumn('liquidation_valide');
        });
    }
};
