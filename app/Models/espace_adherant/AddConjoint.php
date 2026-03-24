<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AdherentVisa;

class AddConjoint extends Model
{
    use HasFactory;

    protected $table = 'add_conjoints';

    // Colonnes modifiables
    protected $fillable = [
        'parent_id',
        'ine',
        'nom',
        'prenom',
        'sexe',
        'dateNaiss',
        'lieuNaiss',
        'avatar',
        'typedoc',
        'typedoc_conjoint',
        'numact',
        'numero',
        'tel1',
        'tel2',
        'email',
    ];

    // Relation vers le parent (l’adhérent)
    public function parent()
    {
        return $this->belongsTo(Adherant::class, 'parent_id');
    }

    // Relation vers le dossier des documents
    public function dossier()
    {
        return $this->hasOne(DossierConjoint::class, 'conjoint_id');
    }

    // Relation vers les visas si nécessaire
    public function visas()
    {
        return $this->morphMany(AdherentVisa::class, 'visaable');
    }

    /**
     * Vérifie si le conjoint peut être ajouté.
     * Un conjoint ne peut être ajouté si le parent est déjà mutualiste.
     */
    public static function peutAjouter($parent_id)
    {
        $parent = Adherant::find($parent_id);
        if (!$parent) return false;

        // Si le parent est déjà mutualiste, on ne peut pas ajouter le conjoint
        return $parent->statut !== 'Mutualiste';
    }
}