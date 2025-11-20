<?php
namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddConjoint extends Model
{
    use HasFactory;

    protected $table = 'add_conjoints';

    protected $fillable = [
        'parent_id',        // ID du parent (adhérent)
        'nom',
        'prenom',
        'sexe',
        'dateNaiss',
        'lieuNaiss',
        'ine',              // Optionnel : INE de l’enfant
        'avatar',
        'typedoc',
        'typedoc_conjointt',
        'numact',
        'numero',
        'tel1',
        'tel2',
        'email',
        'doc_cni',
        'doc_act',
        'doc_recu',
        'doc_carte_conjointt'
    ];

    // 🔗 Relation vers le conjointt
    public function parent()
    {
        return $this->belongsTo(Adherant::class, 'parent_id');
    }

    /**
     * Vérifie si un conjoint existe déjà pour le même mutualiste
     * selon la combinaison unique : parent_id + nom + prenom + dateNaiss
     */
    public static function existePourParent($parentId, $nom, $prenom, $dateNaiss)
    {
        return self::where('parent_id', $parentId)
                    ->where('nom', $nom)
                    ->where('prenom', $prenom)
                    ->where('dateNaiss', $dateNaiss)
                    ->exists();
    }
}
