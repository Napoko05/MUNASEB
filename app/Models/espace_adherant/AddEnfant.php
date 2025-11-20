<?php
namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddEnfant extends Model
{
    use HasFactory;

    protected $table = 'add_enfants';

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
        'typedoc_parent',
        'numdoc',
        'numero',
        'tel1',
        'tel2',
        'email',
    ];

    // 🔗 Relation vers le parent
    public function parent()
    {
        return $this->belongsTo(Adherant::class, 'parent_id');
    }

    // 🔗 Relation vers les documents de l'enfant
    public function dossier()
    {
        return $this->hasOne(DossierEnfant::class, 'add_enfant_id');
    }

    /**
     * Vérifie si un enfant existe déjà pour le même parent
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
