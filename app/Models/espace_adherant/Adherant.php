<?php
namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherant extends Model
{
    use HasFactory;

    protected $table = 'adherant';

    protected $fillable = [
        'ine','nom','prenom','sexe','dateNaiss','lieuNaiss','typedoc','numdoc',
        'tel1','tel2','email','idUniversite','idFiliere','type_adherant','numero_adhesion',
        'date_adhesion','commentaire'
    ];

    // Relations
    public function universite()
    {
        return $this->belongsTo(Universite::class, 'idUniversite');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'idFiliere');
    }

    public function enfants()
    {
        return $this->hasMany(AddEnfant::class, 'parent_id');
    }

    public function conjoints()
    {
        return $this->hasMany(AddConjoint::class, 'parent_id');
    }

    public function dossier()
    {
        return $this->hasOne(DossierAdherant::class, 'adherant_id');
    }
}
