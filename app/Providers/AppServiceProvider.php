<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Composer qui s'applique à toutes les vues
        View::composer('*', function ($view) {

            $defaultLayout = 'layouts.app'; // layout par défaut
            $layout = $defaultLayout;

            if (auth()->check()) {
                $user = auth()->user();

                // Récupère le premier rôle de l'utilisateur ou null
                $role = $user->getRoleNames()->first() ?? null;

                if ($role) {
                    $role = strtolower($role); // uniformise la casse

                    // Mapping des rôles vers les layouts
                    $roleLayouts = [
                        'admin'                 => 'layouts.admin',
                        'etudiant'              => 'layouts.etudiant_app',
                        'regie_recette'         => 'layouts.regie_app',
                        'liquidation_production'    => 'layouts.liquidation_app',
                        'medecin'               => 'layouts.medecin_app',
                        'medecin_conseil'       => 'layouts.medecin_conseil_app',
                        'finance'               => 'layouts.finance_app',
                        'directeur'             => 'layouts.directeur_app',
                        'tresorier'             => 'layouts.tresorier_app',
                    ];

                    if (array_key_exists($role, $roleLayouts)) {
                        $layout = $roleLayouts[$role];
                    } else {
                        // Role inconnu, log pour debug
                        Log::warning("Utilisateur ID {$user->id} a un rôle inconnu: {$role}");
                        $layout = $defaultLayout;
                    }
                }
            }

            $view->with('layout', $layout);
        });
    }
}
