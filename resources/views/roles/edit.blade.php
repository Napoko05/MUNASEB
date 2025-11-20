<!-- Titre de la page (pour le modal) -->
<h5 id="pageTitle">Modification du rôle</h5>

@if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> Il y a eu quelques problèmes avec votre saisie.<br><br>
      <ul>
         @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
         @endforeach
      </ul>
    </div>
@endif

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Nom du rôle -->
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Nom du rôle :</strong>
                <input type="text" name="name" placeholder="Nom" 
                       class="form-control" value="{{ $role->name }}">
            </div>
        </div>

        <!-- Permissions en tableau -->
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Permissions :</strong>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permission as $value)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" 
                                               name="permission[{{ $value->id }}]" 
                                               value="{{ $value->id }}" 
                                               {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ ucfirst($value->name) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bouton de sauvegarde -->
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="ph-solid ph ph-floppy-disk"></i> Sauvegarder
            </button>
        </div>
    </div>
</form>
