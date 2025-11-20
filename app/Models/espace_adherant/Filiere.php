<?php

namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $table = 'filieres';
    protected $fillable = ['nom', 'idUniversite'];
    public $timestamps = false;

    // Relation : une filière appartient à une université
    public function universite()
    {
        return $this->belongsTo(Universite::class, 'idUniversite');
    }
}
