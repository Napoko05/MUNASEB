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
        'motif_rejet', // ✅ AJOUT IMPORTANT
        'date_decision'
    ];

    protected $casts = [
        'date_decision' => 'datetime',
    ];

    /* ===============================
       RELATIONS
    =============================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adherant()
    {
        return $this->belongsTo(Adherant::class);
    }

    /* ===============================
       BOOT (AUTO GESTION)
    =============================== */

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($visa) {
            // ✅ sécuriser les décisions
            $allowed = ['valide', 'rejete', 'en_attente'];

            if (!in_array($visa->decision, $allowed)) {
                throw new \Exception("Décision invalide");
            }
        });
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

    /* ===============================
       SCOPES (PUISSANT)
    =============================== */

    public function scopeValide($query)
    {
        return $query->where('decision', 'valide');
    }

    public function scopeRejete($query)
    {
        return $query->where('decision', 'rejete');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('decision', 'en_attente');
    }
}