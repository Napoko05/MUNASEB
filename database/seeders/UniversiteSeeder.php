<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversiteSeeder extends Seeder
{
    public function run()
    {
        DB::table('universites')->insert([
            // === UNIVERSITÉS PUBLIQUES ===
            ['nom' => 'Université Joseph Ki-Zerbo'],
            ['nom' => 'Université Thomas Sankara'],
            ['nom' => 'Université Norbert Zongo'],
            ['nom' => 'Université Nazi Boni'],

            // === ÉCOLES NORMALES & ÉCOLES PUBLIQUES ===
            ['nom' => 'École Normale Supérieure de Koudougou (ENS-K)'],
            ['nom' => 'École Normale Supérieure de Ouagadougou (ENS-O)'],
            ['nom' => 'École Nationale de Santé Publique (ENSP)'],
            ['nom' => 'École Nationale des Régies Financières (ENAREF)'],

            // === INSTITUTS UNIVERSITAIRES ===
            ['nom' => 'Institut des Sciences (IDS)'],
            ['nom' => 'Institut Supérieur des Sciences de la Population (ISSP)'],
            ['nom' => 'Institut des Sciences de la Santé (INSSA)'],
            ['nom' => 'Institut Universitaire de Technologies (IUT)'],
            ['nom' => 'Institut de Génie de l’Eau et de l’Environnement (IGEE)'],

            // === ÉTABLISSEMENTS PUBLIQUES SEMI-UNIVERSITAIRES ===
            ['nom' => 'Institut Africain d’Informatique - Burkina Faso (IAI-BF)'],
            ['nom' => 'Institut Burkinabè des Arts (IBA)'],
        ]);
    }
}
