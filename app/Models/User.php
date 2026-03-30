<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Relation vers le profil Agent
     */
   
    public function agent()
{
    return $this->hasOne(\App\Models\Agent::class);
}

    /**
     * Les attributs assignables en masse
     */
    protected $fillable = [
        'ine',
        'matricule',
        'nom',
        'prenom',
        'email',
        'password',
    ];

    /**
     * Les attributs cachés pour la sérialisation
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts d'attributs
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Récupérer le nom du rôle principal
     */
    public function getRoleNameAttribute()
    {
        return $this->roles->first()?->name;
    }
    
}
