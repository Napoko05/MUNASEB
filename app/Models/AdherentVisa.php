<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\espace_adherant\Adherant;

class AdherentVisa extends Model
{
    protected $fillable = [
        'adherant_id',
        'type',
        'etape',
        'user_id',
        'decision',
        'commentaire',
        'date_decision'
    ];

    // 🔗 utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 adhérant
    public function adherant()
    {
        return $this->belongsTo(Adherant::class);
    }

    /* ===============================
       HELPERS
    =============================== */

    public function isValide()
    {
        return $this->decision === 'valide';
    }

    public function isRejete()
    {
        return $this->decision === 'rejete';
    }

    public function isEnAttente()
    {
        return $this->decision === 'en_attente';
    }
}