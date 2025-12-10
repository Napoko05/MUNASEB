<?php

namespace App\Models\Dashboard\Directeur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Regie\Adhesion;
use App\Models\Dashboard\Regie\Reabonnement;


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
