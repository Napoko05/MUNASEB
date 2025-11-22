<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\espace_adherant\Adherant;
use App\Models\espace_adherant\Agent;
use Barryvdh\DomPDF\Facade\Pdf;              // PDF
use SimpleSoftwareIO\QrCode\Facades\QrCode; // QRCode
use Illuminate\Support\Facades\Storage;     // Storage
use App\Http\Controllers\Controller;

class CarteAdhesionController extends Controller
{
    // Génération PDF recto-verso
    public function generate($id)
    {
        $adherant = Adherant::findOrFail($id);

        // Agent validateur lié à l’adhésion
        $agent = Agent::find($adherant->validated_by);

        // Génération QR code vers profil adhérent
        $qr = QrCode::format('png')->size(120)->generate(url('adherant/' . $adherant->id));
        $qrPath = 'qrcodes/' . $adherant->id . '.png';
        Storage::put('public/' . $qrPath, $qr);

        // Génération PDF recto-verso (2 pages)
        $pdf = Pdf::loadView(
            ['adherant.carte_recto', 'adherant.carte_verso'],
            compact('adherant', 'agent', 'qrPath')
        )->setPaper('a7', 'landscape');

        return $pdf->download('carte_' . $adherant->numeroCarte . '.pdf');
    }

    // Génération du numéro unique de carte
    private function generateCarteNumero()
    {
        $year = date('y');   // 2 derniers chiffres de l'année
        $minute = date('i'); // minute
        $second = date('s'); // seconde
        $random = rand(100, 999); // 3 chiffres aléatoires

        return $year . $minute . $second . $random;
    }

    // Création de carte avec numéro unique
    public function createCarte($id)
    {
        $adherant = Adherant::findOrFail($id);

        // Générer le numéro unique
        $numeroCarte = $this->generateCarteNumero();

        // Sauvegarder dans la base
        $adherant->numeroCarte = $numeroCarte;
        $adherant->save();

        // Passer à la vue Blade recto
        $agent = Agent::find($adherant->validated_by);
        return view('adherant.carte_recto', compact('adherant','agent'));
    }
}
