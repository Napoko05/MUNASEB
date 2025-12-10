<?php

namespace App\Models\Dashboard\Regie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reabonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_id',
        'statut',          // en_attente, traite, rejete
        'date_soumission',
        'commentaire',
        'documents',
    ];

    // Relation vers le profil
    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }
}
