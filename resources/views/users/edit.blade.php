<h5 id="pageTitle">Modification utilisateur</h5>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Il y a eu quelques problèmes avec votre saisie.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>INE:</strong>
            <input type="text" name="ine" placeholder="INE étudiant" class="form-control" value="{{ old('ine', $user->ine) }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Matricule:</strong>
            <input type="text" name="matricule" placeholder="Matricule étudiant" class="form-control" value="{{ old('matricule', $user->matricule) }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Nom :</strong>
            <input type="text" name="nom" placeholder="Nom" class="form-control" value="{{ old('nom', $user->nom) }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Prénom :</strong>
            <input type="text" name="prenom" placeholder="Prénom" class="form-control" value="{{ old('prenom', $user->prenom) }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            <input type="password" name="password" placeholder="Password" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="roles[]" class="form-control" multiple="multiple">
                @foreach ($roles as $value => $label)
                <option value="{{ $value }}" {{ in_array($value, old('roles', $userRole ?? [])) ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
            <i class="ph-solid ph ph-floppy-disk"></i> Sauvegarder
        </button>
    </div>
</form>