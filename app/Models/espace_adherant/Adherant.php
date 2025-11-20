<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\espace_adherant\Profil;
use App\Models\espace_adherant\Universite;
use App\Models\espace_adherant\Filiere;
use App\Models\espace_adherant\AddEnfant;

class Adherant extends Model
{
    use HasFactory;

    protected $table = 'adherant';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'ine',
        'nom',
        'prenom',
        'sexe',
        'dateNaiss',
        'lieuNaiss',
        'typedoc',
        'numdoc',
        'tel1',
        'tel2',
        'email',
        'idUniversite',
        'idFiliere',
        'type_adherant',
        'profil_id',
        'numero_adhesion',
        'date_adhesion',
        'commentaire',
        // 'document_justificatif', // supprimé
    ];

    // 🔗 Relations

    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

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

    // 🔗 Relation avec les documents
    public function dossier()
    {
        return $this->hasOne(DossierAdherant::class);
    }
}


