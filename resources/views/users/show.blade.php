
<!-- Titre de la page (pour le modal) -->
<h5 id="pageTitle">Visualisation utilisateur</h5>
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
<form method="POST" action="">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $user->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roles:</strong>
            <span class="badge bg-success">{{ $userRoles[0] }}</span>
                
        </div>
    </div>
</div>
</form>
