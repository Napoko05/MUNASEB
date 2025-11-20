<?php
namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierConjoint extends Model
{
    use HasFactory;

    protected $table = 'dossiers_conjoints';

    protected $fillable = [
        'conjoint_id',
        'document_cni',
        'document_acte_mariage',
        'document_recu',
        'document_carte',
    ];

    public function conjoint()
    {
        return $this->belongsTo(Conjoint::class, 'conjoint_id');
    }
}
