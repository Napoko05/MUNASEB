@include('layouts.head')
@include('layouts.sidebar')

<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block card mb-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h4 class="mb-0">Gestion des roles</h4>
                        </div>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}"><i class="ph ph-shield"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Liste des roles</a></li>
                            </ul>
                            <hr>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <!-- Bouton Ajouter -->
                         @can('role-create')
                        <button type="button" class="btn btn-success btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#userModal"
                                data-url="{{ route('roles.create') }}">
                            <i class="ph ph-plus"></i> Nouveau role
                        </button>
                        @endcan
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
                                    <th>Désignation</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#userModal"
                                                data-url="{{ route('roles.show',$role->id) }}">  
                                            <i class="ph-solid ph ph-list"></i> Show
                                        </button>
                                        
                                        @can('role-edit')
                                            <button class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#userModal"
                                                    data-url="{{ route('roles.edit',$role->id) }}">
                                                <i class="ph-solid ph ph-pen-to-square"></i> Edit
                                            </button>
                                            
                                        @endcan

                                        @can('role-delete')
                                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"><i class="ph-solid ph ph-trash"></i> Delete</button>
                                        </form>
                                        @endcan
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

</script>
