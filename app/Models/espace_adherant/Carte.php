<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Carte extends Model
{
    use HasFactory;

    /**
     * Table associée
     */
    protected $table = 'cartes';

    /**
     * Champs remplissables
     */
    protected $fillable = [
        'adherant_id',
        'numero_carte',
        'date_effet',
        'date_validite',
        'signature_directeur',
        'directeur_visa',
        'liquidation_visa',
        'regie_visa',
        'regie_valide',
        'qr_code_path',
        'statut',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'date_effet'    => 'date',
        'date_validite' => 'date',
    ];

    /**
     * Relation : une carte appartient à un adhérent
     */
    public function adherant()
    {
        return $this->belongsTo(Adherant::class, 'adherant_id');
    }

    /**
     * 🔎 Carte valide ?
     */
    public function estValide(): bool
    {
        return $this->date_validite >= Carbon::now();
    }

    /**
     * Carte expirée ?
     */
    public function estExpiree(): bool
    {
        return $this->date_validite < Carbon::now();
    }
}
