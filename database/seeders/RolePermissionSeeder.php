<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        /* =========================
        PERMISSIONS
        ========================== */

        $permissions = [

            // gestion roles utilisateurs
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            // dashboard
            'view-dashboard',

            // profil
            'view-profile',
            'edit-profile',

            // adhesion
            'create-adhesion',
            'renouveler-adhesion',
            'view-adhesions',
            'approve-adhesion',
            'rejet-adhesion',
            'delete-adhesion',

            // carte
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

            // medical
            'consulter_patient',
            'creer_bon_soin',
            'creer_ordonnance',

            // statistiques
            'view-statistique',

            // admin system
            'gerer_utilisateurs',
            'gerer_roles',
            'configurer_systeme',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /* =========================
        ROLES
        ========================== */

        $roles = [
            'admin',
            'etudiant',
            'regie_recette',
            'liquidation_production',
            'medecin',
            'medecin_conseil',
            'finance',
            'directeur',
            'tresorier',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        /* =========================
        RECUPERATION ROLES
        ========================== */

        $admin = Role::findByName('admin');
        $etudiant = Role::findByName('etudiant');
        $regie = Role::findByName('regie_recette');
        $liquidation = Role::findByName('liquidation_production');
        $medecin = Role::findByName('medecin');
        $medecinConseil = Role::findByName('medecin_conseil');
        $finance = Role::findByName('finance');
        $directeur = Role::findByName('directeur');
        $tresorier = Role::findByName('tresorier');

        /* =========================
        PERMISSIONS PAR ROLE
        ========================== */

        // admin
        $admin->syncPermissions(Permission::all());

        // etudiant
        $etudiant->syncPermissions([
            'view-dashboard',
            'create-adhesion',
            'renouveler-adhesion',
            'soumettre_remboursement',
            'consulter_dossier',
            'supprimer-demande',
            'view-profile',
            'edit-profile',
        ]);

        // regie
        $regie->syncPermissions([
            'view-dashboard',
            'view-adhesions',
            'create-adhesion',
            'approve-adhesion',
            'rejet-adhesion',
            'view-profile',
            'edit-profile',
            'view-statistique'
        ]);

        // liquidation
        $liquidation->syncPermissions([
            'view-dashboard',
            'view-adhesions',
            'create-carte',
            'traiter-remboursement',
            'creer-autorisation',
            'view-statistique'
        ]);

        // medecin
        $medecin->syncPermissions([
            'view-dashboard',
            'consulter_patient',
            'creer_bon_soin',
            'creer_ordonnance',
            'view-statistique'
        ]);

        // medecin conseil
        $medecinConseil->syncPermissions([
            'view-dashboard',
            'valider_remboursement_medical',
            'rejeter_remboursement',
            'edit-remboursement',
            'view-statistique'
        ]);

        // finance
        $finance->syncPermissions([
            'view-dashboard',
            'verifier_plafond',
            'preparer_bordereau',
            'view-statistique'
        ]);

        // directeur
        $directeur->syncPermissions([
            'view-dashboard',
            'approve-adhesion',
            'valider-bordereau',
            'view-statistique'
        ]);

        // tresorier
        $tresorier->syncPermissions([
            'view-dashboard',
            'payer_remboursement',
            'gerer_fonds',
            'view-statistique'
        ]);

        /* =========================
        ADMIN PAR DEFAUT
        ========================== */

        $adminUser = User::first();

        if ($adminUser) {
            $adminUser->assignRole('admin');
        }
    }
}
