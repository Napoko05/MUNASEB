<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // gestion roles/utilisateurs
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            // dashboard / profil
            'view-dashboard',
            'view-profile',
            'edit-profile',

            // adhésion
            'create-adhesion',
            'renouveler-adhesion',
            'view-adhesions',
            'approve-adhesion',
            'rejet-adhesion',
            'edit-adhesion',
            'delete-adhesion',

            // carte mutualiste
            'create-carte',

            // remboursement
            'soumettre_remboursement',
            'consulter_dossier',
            'supprimer-demande',
            'traiter-remboursement',
            'valider_remboursement_medical',
            'rejeter_remboursement',
            'edit-remboursement',

            // liquidation
            'creer-autorisation',

            // finance
            'verifier_plafond',
            'preparer_bordereau',
            'valider-bordereau',

            // paiement
            'payer_remboursement',
            'gerer_fonds',

            // médical
            'consulter_patient',
            'creer_bon_soin',
            'creer_ordonnance',

            // statistiques
            'view-statistique',

            // administration système
            'gerer_utilisateurs',
            'gerer_roles',
            'configurer_systeme',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
