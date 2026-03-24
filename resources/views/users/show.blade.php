<!-- Titre de la page (pour le modal) -->
<h5 id="pageTitle">Visualisation utilisateur</h5>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Matricule:</strong>
            {{ $user->matricule ?? '-' }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nom:</strong>
            {{ $user->nom ?? '-' }}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Prénom:</strong>
            {{ $user->prenom ?? '-' }}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email ?? '-' }}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Rôle{{ count($userRoles) > 1 ? 's' : '' }}:</strong>
            @if(!empty($userRoles))
            @foreach($userRoles as $role)
            <span class="badge bg-success">{{ $role }}</span>
            @endforeach
            @else
            <span>-</span>
            @endif
        </div>
    </div>
</div>