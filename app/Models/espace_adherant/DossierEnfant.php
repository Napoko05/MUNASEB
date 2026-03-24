<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierEnfant extends Model
{
    use HasFactory;

    // ⚠️ Le nom de la table doit correspondre à ta migration
    protected $table = 'dossier_enfants';

    // Colonnes définies dans la migration et utilisées par ton contrôleur
    protected $fillable = [
        'enfant_id',
        'doc_extrait',
        'doc_cni_parent',
        'document_recu',
        'document_carte',
    ];

    // Relation avec l'enfant
    public function enfant()
    {
        return $this->belongsTo(AddEnfant::class, 'enfant_id');
    }
}
