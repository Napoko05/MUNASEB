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
        // Liste des permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',


        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Création des rôles

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Autres rôles spécifiques
        $roles = [
            'etudiant',
            'regie_recette',
            'directeur',
            'liquidation_production',
            'tresorier',
            
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Attribution de toutes les permissions au rôle admin
        $adminRole->syncPermissions(Permission::all());
        $permissions = [
            'view-adhesions',        // Voir les adhésions
            'create-adhesion',       // Créer une adhésion
            'edit-adhesion',         // Modifier une adhésion
            'delete-adhesion',       // Supprimer une adhésion
            'rejet-adhesion',        // Rejeter une adhésion
            'approve-adhesion',      // Valider / approuver une adhésion
            'view-profile',          // Voir le profil
            'edit-profile',          // Modifier le profil
            'view-dashboard',        // Accéder au tableau de bord
            'payer-etudiant',        // Permettre au trésorier de passer au paiement
            'dossier-non-traite',    // Pour ragie_recette et liquidation
            // Ajoute d'autres permissions spécifiques si nécessaire
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        // Assigner le rôle admin au premier utilisateur
        $admin = User::first();
        if ($admin) {
            $admin->assignRole('admin');
        }
        // Récupérer les rôles
        $regie = Role::findByName('regie_recette');
        $directeur = Role::findByName('directeur');
        $liquidation = Role::findByName('liquidation_production');
        $tresorier = Role::findByName('tresorier');
        $etudiant = Role::findByName('etudiant');

        // Rôles et permissions
        $regie->syncPermissions([
            'dossier-non-traite',
            'rejet-adhesion',
        ]);

        $directeur->syncPermissions(Permission::all()); // Tous les droits

        $liquidation->syncPermissions([
            'dossier-non-traite',
            'approve-adhesion',
            'rejet-adhesion',
        ]);

        $tresorier->syncPermissions([
            'view-adhesions',
            'payer-etudiant',
        ]);

        $etudiant->syncPermissions([
            'create-adhesion',
            'edit-profile',
            'view-profile',
        ]);
    }
}
