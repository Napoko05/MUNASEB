<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierAdherant extends Model
{
    use HasFactory;

    protected $table = 'dossiers_adherant';

    protected $fillable = [
    'adherant_id',
    'photo',
    'document_cni',
    'document_attestation',
    'document_recu',
    'statut',
    'regie_valide',        // ✅ ajouté
    'liquidation_valide',  // déjà présent
    'liquidation_visa',    // pour savoir qui a validé
    'motif_rejet',         // pour rejets
];

    /**
     * 🔗 Relation inverse vers Adherant
     * Chaque dossier appartient à un adhérent
     */
    public function adherant()
    {
        return $this->belongsTo(Adherant::class);
    }
}
