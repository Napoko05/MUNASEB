<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->text('motif_rejet')->nullable()->after('statut');
        });
    }

    public function down()
    {
        Schema::table('dossiers_adherant', function (Blueprint $table) {
            $table->dropColumn('motif_rejet');
        });
    }
};
