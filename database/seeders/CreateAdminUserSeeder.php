<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Mot de passe admin
        $password = 'Password1!';

        // Vérifier si le rôle admin existe
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Création ou récupération de l'admin
        $user = User::firstOrCreate(
            ['email' => 'napoko@gmail.com'],
            [
                'nom' => 'Savadogo',
                'prenom' => 'Lamine',
                'matricule' => 'ADM001',
                'ine' => null,
                'password' => Hash::make($password),
            ]
        );

        // Assigner le rôle admin s'il ne l'a pas
        if (!$user->hasRole('admin')) {
            $user->assignRole($role);
        }

        // Message dans la console
        $this->command->info('Admin créé avec succès :');
        $this->command->info('Login (matricule) : ADM001');
        $this->command->info('Email : napoko@gmail.com');
        $this->command->info("Mot de passe : $password");
    }
}
