
<!-- Titre de la page (pour le modal) -->
<h5 id="pageTitle">Ajouter un nouvel utilisateur</h5>

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

<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>INE:</strong>
            <input type="text" name="ine" placeholder="INE étudiant" class="form-control" value="{{ old('ine') }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Matricule:</strong>
            <input type="text" name="matricule" placeholder="Matricule étudiant" class="form-control" value="{{ old('matricule') }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Nom :</strong>
            <input type="text" name="nom" placeholder="Nom" class="form-control" value="{{ old('nom') }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Prénom :</strong>
            <input type="text" name="prenom" placeholder="Prénom" class="form-control" value="{{ old('prenom') }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Mot de passe:</strong>
            <input type="password" name="password" placeholder="Password" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirme mot de passe:</strong>
            <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="roles[]" class="form-control" multiple="multiple">
                @foreach ($roles as $value => $label)
                    <option value="{{ $value }}" {{ (collect(old('roles'))->contains($value)) ? 'selected' : '' }}>
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

