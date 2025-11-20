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
    ];

    // 🔗 Relation inverse vers Adherant
    public function adherant()
    {
        return $this->belongsTo(Adherant::class);
    }
}
