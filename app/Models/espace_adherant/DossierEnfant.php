<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierEnfant extends Model
{
    use HasFactory;

    protected $table = 'dossiers_enfants';

    protected $fillable = [
        'adherant_id',
        'document_extrait_naissance',
        'document_cni_parent',
    ];

    public function adherant()
    {
        return $this->belongsTo(Adherant::class);
    }
}
