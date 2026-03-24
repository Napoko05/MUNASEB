<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    // Middleware permissions si besoin
    /*function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }*/

    // Liste des utilisateurs
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $query = User::latest();

        if ($search) {
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ine', 'like', "%{$search}%");
        }

        $data = $query->paginate(5);

        if ($request->ajax()) {
            return view('users.partials.table', compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }

        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    // Formulaire création
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    // Stocker nouvel utilisateur
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'ine' => 'required|string|unique:users,ine',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->only(['ine','nom','prenom','email','password']);
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    // Afficher utilisateur
    public function show($id): View
    {
        $user = User::findOrFail($id);
        $userRoles = $user->roles->pluck('name')->all();

        return view('users.show', compact('user', 'userRoles'));
    }

    // Formulaire édition
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    // Mise à jour utilisateur
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'ine' => 'required|string|unique:users,ine,' . $id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->only(['ine','nom','prenom','email','password']);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::findOrFail($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    // Supprimer utilisateur
    public function destroy($id): RedirectResponse
    {
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }
}