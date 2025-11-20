<?php

namespace App\Models\Dashboard\Regie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adhesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_id',
        'numero_adhesion',
        'date_adhesion',
        'statut',
        'commentaire',
        'document_justificatif',
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'profil_id');
    }
}
