<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création utilisateur test (facultatif)
        User::factory()->create([
            'nom' => 'To',
            'prenom' => 'Toto',
            'matricule' => 'TA001',
            'email' => 'test@example.com',
        ]);

        // Appel des Seeders
        $this->call([
            PermissionTableSeeder::class,
            RolePermissionSeeder::class,
            UniversiteSeeder::class,
            FiliereSeeder::class,
            CreateAdminUserSeeder::class,
            
        ]);
    }
}
