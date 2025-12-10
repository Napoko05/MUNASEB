<?php

namespace App\Models\Dashboard\Regie;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dossier extends Model
{
    protected $table = 'dossiers'; // Nom de la table si différent du pluriel par défaut

    protected $fillable = [
        'profil_id',
        'statut',
        'type',
        'date_demande',
        // Ajoute ici les autres colonnes pertinentes
    ];

    /**
     * Relation avec le modèle Profil
     */
    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    /**
     * Scope pour les dossiers en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
}