@include('layouts.head')
@include('layouts.sidebar')

<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block card mb-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h4 class="mb-0">Gestion des utilisateurs</h4>
                        </div>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('users.index') }}"><i class="ph ph-user"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Liste des utilisateurs</a></li>
                            </ul>
                            <hr>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <!-- Bouton Ajouter -->
                        <button type="button" class="btn btn-success btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#userModal"
                                data-url="{{ route('users.create') }}">
                            <i class="ph ph-plus"></i> Nouveau utilisateur
                        </button>
                    </div>

                    <div class="table-responsive">
                      @session('success')
                          <div class="alert alert-success" role="alert"> 
                              {{ $value }}
                          </div>
                      @endsession
                        <table id="usersTable" class="table table-hover align-middle table-striped dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td><img src="storage/assets/images/user/avatar-2.jpg" alt="user-image" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;" /></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <span class="badge bg-success">{{ $v }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#userModal"
                                                data-url=" {{ route('users.show',$user->id) }}">  
                                            <i class="ph-solid ph ph-list"></i> Show
                                        </button>
                                        <button class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#userModal"
                                                data-url="{{ route('users.edit', $user->id) }}">
                                            <i class="ph-solid ph ph-pen-to-square"></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="ph-solid ph ph-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach  
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="permissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Accès refusé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="permissionModalBody">
        <!-- Le message sera injecté ici -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>


@include('layouts.modal')
@include('layouts.footer')

<script>
  $(document).ready(function() {
    $('#usersTable').DataTable({
        responsive: true,
        paging: true,
        pageLength: 5,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: false,
        language: {
            search: "",
            searchPlaceholder: "Rechercher..."
        }
    });
});

// --- Chargement AJAX dans le modal pour Ajouter / Éditer ---
var userModal = document.getElementById('userModal');

userModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const url = button.getAttribute('data-url');
    const modalBody = userModal.querySelector('.modal-body');
    const modalTitle = document.getElementById('userModalLabel');

    if (!url) return;

    modalTitle.textContent = 'Chargement...';
    modalBody.innerHTML = '<p>Chargement...</p>';

    fetch(url)
        .then(response => response.text())
        .then(html => {
            modalBody.innerHTML = html;

            // Récupérer le titre depuis #pageTitle si présent dans la vue create/edit
            const pageTitle = modalBody.querySelector('#pageTitle');
            if (pageTitle) {
                modalTitle.textContent = pageTitle.textContent;
                pageTitle.remove(); // retirer le titre du formulaire
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="alert alert-danger">Impossible de charger le formulaire.</div>';
            console.error(error);
        });
});




function openPermissionModal(message) {
    document.getElementById('permissionModalBody').innerText = message;
    var modal = new bootstrap.Modal(document.getElementById('permissionModal'));
    modal.show();
}

// Exemple d'appel via AJAX
function editUser(userId) {
    axios.get('/users/' + userId + '/edit')
        .then(response => {
            if (response.data.status === 'success') {
                // Charger le formulaire dans un div
                document.getElementById('editFormContainer').innerHTML = response.data.html;
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 403) {
                openPermissionModal(error.response.data.message);
            } else {
                console.error(error);
            }
        });
}


</script>
