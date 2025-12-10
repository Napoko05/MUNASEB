<?php

namespace App\Models\Dashboard\Regie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'nom', 
        'prenom', 
        'email',
        'tel', 
        'ine', 
        'dateNaiss', 
        'lieuNaiss',
        // ajoute les autres champs nécessaires
    ];

    // Relation avec le compte utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les adhésions
    public function adhesions()
    {
        return $this->hasMany(Adhesion::class);
    }

    // Relation avec les réabonnements
    public function reabonnements()
    {
        return $this->hasMany(Reabonnement::class);
    }
}
