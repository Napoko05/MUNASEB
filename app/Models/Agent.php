<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Agent extends Model
{
    use HasFactory;

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Champs assignables en masse
     */
    protected $fillable = [
        'user_id',
        'sexe',
        'lieu_naissance',
        'date_naissance',
        'num_cnib',
        'service',
        'tel',
        'ville',
        'specialite',
        'cnib_file',
        'attestation_travail_file',
        'diplome_file',
        'signature_file',
    ];

    /**
     * Casts pour certains champs
     */
    protected $casts = [
        'date_naissance' => 'date',
    ];

    /**
     * Accesseurs pour fichiers
     */
    public function getCnibFileUrlAttribute()
    {
        return $this->cnib_file ? asset('storage/' . $this->cnib_file) : null;
    }

    public function getAttestationTravailFileUrlAttribute()
    {
        return $this->attestation_travail_file ? asset('storage/' . $this->attestation_travail_file) : null;
    }

    public function getDiplomeFileUrlAttribute()
    {
        return $this->diplome_file ? asset('storage/' . $this->diplome_file) : null;
    }

    public function getSignatureFileUrlAttribute()
    {
        return $this->signature_file ? asset('storage/' . $this->signature_file) : null;
    }

    /**
     * Création complète de l'agent avec User et mot de passe
     * 
     * @param array $agentData - Données spécifiques à Agent
     * @param array $userData - Données pour User (nom, prenom, email, matricule, password, role)
     * @return self
     */
    public static function createWithUser(array $agentData, array $userData)
    {
        // Création du User pour connexion
        $user = \App\Models\User::create([
            'nom' => $userData['nom'],
            'prenom' => $userData['prenom'],
            'email' => $userData['email'],
            'matricule' => $userData['matricule'],
            'password' => Hash::make($userData['password']),
        ]);

        // Assigner rôle si fourni
        if (!empty($userData['role'])) {
            $user->assignRole($userData['role']);
        }

        // Créer l'Agent lié au User
        $agentData['user_id'] = $user->id;
        $agent = self::create($agentData);

        return $agent;
    }
}