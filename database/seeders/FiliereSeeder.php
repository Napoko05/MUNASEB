<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FiliereSeeder extends Seeder
{
    public function run()
    {
        $filieres = [

            // ====================================================
            // UNIVERSITÉ JOSEPH KI-ZERBO
            // ====================================================
            ['nom' => 'Médecine', 'idUniversite' => 1],
            ['nom' => 'Pharmacie', 'idUniversite' => 1],
            ['nom' => 'Odontostomatologie', 'idUniversite' => 1],
            ['nom' => 'Biologie', 'idUniversite' => 1],
            ['nom' => 'Chimie', 'idUniversite' => 1],
            ['nom' => 'Mathématiques', 'idUniversite' => 1],
            ['nom' => 'Physique', 'idUniversite' => 1],
            ['nom' => 'Informatique', 'idUniversite' => 1],
            ['nom' => 'Géographie', 'idUniversite' => 1],
            ['nom' => 'Histoire', 'idUniversite' => 1],
            ['nom' => 'Sociologie', 'idUniversite' => 1],
            ['nom' => 'Psychologie', 'idUniversite' => 1],
            ['nom' => 'Économie', 'idUniversite' => 1],
            ['nom' => 'Gestion', 'idUniversite' => 1],

            // ====================================================
            // UNIVERSITÉ THOMAS SANKARA
            // ====================================================
            ['nom' => 'Économie', 'idUniversite' => 2],
            ['nom' => 'Gestion des Ressources Humaines', 'idUniversite' => 2],
            ['nom' => 'Comptabilité', 'idUniversite' => 2],
            ['nom' => 'Marketing', 'idUniversite' => 2],
            ['nom' => 'Audit et Contrôle', 'idUniversite' => 2],
            ['nom' => 'Gestion Financière', 'idUniversite' => 2],

            // ====================================================
            // UNIVERSITÉ NORBERT ZONGO
            // ====================================================
            ['nom' => 'Lettres Modernes', 'idUniversite' => 3],
            ['nom' => 'Anglais', 'idUniversite' => 3],
            ['nom' => 'Philosophie', 'idUniversite' => 3],
            ['nom' => 'Histoire', 'idUniversite' => 3],
            ['nom' => 'Génie Informatique', 'idUniversite' => 3],
            ['nom' => 'Sciences Juridiques', 'idUniversite' => 3],

            // ====================================================
            // UNIVERSITÉ NAZI BONI
            // ====================================================
            ['nom' => 'Sciences Biologiques', 'idUniversite' => 4],
            ['nom' => 'Sciences de la Santé', 'idUniversite' => 4],
            ['nom' => 'Génie Civil', 'idUniversite' => 4],
            ['nom' => 'Génie Électrique', 'idUniversite' => 4],
            ['nom' => 'Économie Agricole', 'idUniversite' => 4],
            ['nom' => 'Agronomie', 'idUniversite' => 4],

            // ====================================================
            // ENS-K / ENS-O
            // ====================================================
            ['nom' => 'Professorat des Lycées (PL)', 'idUniversite' => 5],
            ['nom' => 'Sciences de l’Éducation', 'idUniversite' => 5],
            ['nom' => 'Psychopédagogie', 'idUniversite' => 5],

            ['nom' => 'Professorat des Lycées (PL)', 'idUniversite' => 6],
            ['nom' => 'Lettres et Langues', 'idUniversite' => 6],

            // ====================================================
            // INSTITUTS
            // ====================================================
            ['nom' => 'Population et Développement', 'idUniversite' => 10],
            ['nom' => 'Statistique Démographique', 'idUniversite' => 10],

            ['nom' => 'Informatique de Gestion', 'idUniversite' => 14],
            ['nom' => 'Administration Réseaux', 'idUniversite' => 14],
            ['nom' => 'Développement d’Applications', 'idUniversite' => 14],

        ];

        DB::table('filieres')->insert($filieres);
    }
}
