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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Appel des Seeders
        $this->call([
            UniversiteSeeder::class,
            FiliereSeeder::class,
        ]);
    }
}
