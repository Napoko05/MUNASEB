<?php
namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universite extends Model
{
    use HasFactory;

    protected $table = 'universites';
    protected $fillable = ['nom'];
    public $timestamps = false;

    // Relation : une université a plusieurs filières
    public function filieres()
    {
        return $this->hasMany(Filiere::class, 'idUniversite');
    }
}