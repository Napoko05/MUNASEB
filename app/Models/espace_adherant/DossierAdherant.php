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
        'regie_valide',
        'liquidation_valide',
        'liquidation_visa',
        'motif_rejet',
        'statut_global',
    ];

    /**
     * 🔗 Relation inverse vers Adherant
     * Chaque dossier appartient à un adhérent
     */
    public function adherant()
    {
        return $this->belongsTo(Adherant::class);
    }
    public function syncStatutGlobal()
    {
        if ($this->statut === 'rejete') {
            $this->statut_global = 'rejete';
        } elseif ($this->regie_valide && !$this->liquidation_valide) {
            $this->statut_global = 'regie_valide';
        } elseif ($this->liquidation_valide && !$this->liquidation_visa) {
            $this->statut_global = 'liquidation_en_cours';
        } elseif ($this->liquidation_visa && $this->statut !== 'rejete') {
            $this->statut_global = 'carte_creee';
        }

        $this->save();
    }
}
