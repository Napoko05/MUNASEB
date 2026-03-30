<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function create()
    {
        return view('admin.create_agent_step1');
    }

    public function step2(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'num_cnib' => 'required|string|max:100|unique:agents,num_cnib',
            'service' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'specialite' => 'nullable|string|max:255',
            'matricule' => 'required|string|unique:users,matricule',
            'email' => 'required|email|unique:users,email',
            'tel' => 'nullable|string|max:20',
            'password' => 'required|string|confirmed|min:8'
        ]);

        // 🔥 Upload temporaire
        $files = [];
        foreach (['cnib_file', 'attestation_travail_file', 'diplome_file', 'signature_file'] as $file) {
            if ($request->hasFile($file)) {
                $files[$file] = $request->file($file)->store('agents_temp', 'public');
            }
        }

        session([
            'agent_data' => $validated,
            'agent_files' => $files
        ]);

        return redirect()->route('admin.agents.step2.view');
    }

    public function step2View()
    {
        if (!session()->has('agent_data')) {
            return redirect()->route('admin.agents.create');
        }

        $data = session('agent_data');
        $files = session('agent_files', []);
        $roles = Role::all();

        return view('admin.create_agent_step2', compact('data', 'files', 'roles'));
    }

    public function store(Request $request)
    {
        if (!session()->has('agent_data')) {
            return redirect()->route('admin.agents.create');
        }

        $data = session('agent_data');
        $sessionFiles = session('agent_files', []);

        // 🔥 Création user
        $user = User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'matricule' => $data['matricule'],
            'tel' => $data['tel'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        if ($request->role) {
            $user->assignRole($request->role);
        }

        // 🔥 Gestion fichiers robuste
        $finalFiles = [];

        $fields = [
            'cnib_file',
            'attestation_travail_file',
            'diplome_file',
            'signature_file'
        ];

        foreach ($fields as $field) {

            // ✅ CAS 1 : nouvel upload step2
            if ($request->hasFile($field)) {

                $destination = match ($field) {
                    'cnib_file' => 'agents/cnib',
                    'attestation_travail_file' => 'agents/attestations',
                    'diplome_file' => 'agents/diplomes',
                    'signature_file' => 'agents/signatures',
                };

                $finalFiles[$field] = $request->file($field)->store($destination, 'public');
            }

            // ✅ CAS 2 : fichier venant session (step1)
            elseif (!empty($sessionFiles[$field])) {

                $tempPath = $sessionFiles[$field];

                if (Storage::disk('public')->exists($tempPath)) {

                    $destination = match ($field) {
                        'cnib_file' => 'agents/cnib',
                        'attestation_travail_file' => 'agents/attestations',
                        'diplome_file' => 'agents/diplomes',
                        'signature_file' => 'agents/signatures',
                    };

                    $finalPath = $destination . '/' . basename($tempPath);

                    Storage::disk('public')->move($tempPath, $finalPath);

                    $finalFiles[$field] = $finalPath;
                }
            }
        }

        // 🔥 Création agent
        Agent::create([
            'user_id' => $user->id,
            'sexe' => $data['sexe'],
            'date_naissance' => $data['date_naissance'],
            'lieu_naissance' => $data['lieu_naissance'],
            'num_cnib' => $data['num_cnib'],
            'service' => $data['service'],
            'ville' => $data['ville'],
            'specialite' => $data['specialite'] ?? null,
            'cnib_file' => $finalFiles['cnib_file'] ?? null,
            'attestation_travail_file' => $finalFiles['attestation_travail_file'] ?? null,
            'diplome_file' => $finalFiles['diplome_file'] ?? null,
            'signature_file' => $finalFiles['signature_file'] ?? null,
        ]);

        // 🔥 Nettoyage
        session()->forget(['agent_data', 'agent_files']);

        return redirect()->route('dashboard.admin')
            ->with('success', 'Agent créé avec succès !');
    }
}
