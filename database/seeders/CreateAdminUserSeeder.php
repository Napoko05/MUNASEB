<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Admin ----------
        $user = User::firstOrCreate(
            ['email' => 'johnson@gmail.com'],
            ['name' => 'Johnson SOMBIE', 'password' => bcrypt('123456')]
        );

        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Assigner toutes les permissions existantes au rôle Admin
        $role->syncPermissions(Permission::all());

        // Assigner le rôle à l'utilisateur
        $user->assignRole($role);

        // ---------- Ragie ----------
        $ragie = User::firstOrCreate(
            ['email' => 'ragie@example.com'],
            ['name' => 'Regie Recette', 'password' => bcrypt('123456')]
        );

        $ragieRole = Role::firstOrCreate(['name' => 'ragie_recette']);
        $ragie->assignRole($ragieRole);

        // ---------- Directeur ----------
        $directeur = User::firstOrCreate(
            ['email' => 'directeur@example.com'],
            ['name' => 'Directeur Test', 'password' => bcrypt('123456')]
        );

        $directeurRole = Role::firstOrCreate(['name' => 'directeur']);
        $directeur->assignRole($directeurRole);
    }
}
