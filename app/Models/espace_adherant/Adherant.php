<?php
namespace App\Models\espace_adherant; // convention : majuscule au namespace

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\espace_adherant\Universite;
use App\Models\espace_adherant\Filiere;
use App\Models\espace_adherant\AddEnfant;
use App\Models\espace_adherant\AddConjoint;
use App\Models\espace_adherant\DossierAdherant;
use App\Models\Dashboard\Regie\Profil;

class Adherant extends Model
{
    use HasFactory;

    // Nom de la table : si ta table est bien "adherants" au pluriel, corrige ici
    protected $table = 'adherant';

    // Colonnes autorisées en écriture
    protected $fillable = [
        'ine','nom','prenom','sexe','dateNaiss','lieuNaiss','typedoc','numdoc',
        'tel1','tel2','email','idUniversite','idFiliere','type_adherant','numero_adhesion',
        'date_adhesion','commentaire','numeroCarte','date_validite','signature_directeur' 
    ];

    // Relations
    public function universites()
    {
        // clé étrangère idUniversite dans adherants → id dans universites
        return $this->belongsTo(universite::class, 'idUniversite', 'id');
    }

    public function filieres()
    {
        // clé étrangère idFiliere dans adherants → id dans filieres
        return $this->belongsTo(Filiere::class, 'idFiliere', 'id');
    }

    public function enfants()
    {
        return $this->hasMany(AddEnfant::class, 'parent_id', 'id');
    }

    public function conjoints()
    {
        return $this->hasMany(AddConjoint::class, 'parent_id', 'id');
    }

    public function dossier()
    {
        return $this->hasOne(DossierAdherant::class, 'adherant_id', 'id');
    }
     public function profil()
    {
        return $this->hasOne(Profil::class, 'adherant_id');
    }
}
