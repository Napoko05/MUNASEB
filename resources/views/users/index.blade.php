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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('users.index') }}"><i class="ph ph-user"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Liste des utilisateurs</a></li>
                            </ul>
                            <hr>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <button type="button" class="btn btn-success btn-sm"
                            data-bs-toggle="modal" data-bs-target="#userModal"
                            data-url="{{ route('users.create') }}">
                            <i class="ph ph-plus"></i> Nouveau utilisateur
                        </button>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover align-middle table-striped dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Rôles</th> <!-- Nouvelle colonne -->
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->nom ?? '-' }}</td>
                                    <td>{{ $user->prenom ?? '-' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $role)
                                        <span class="badge bg-success">{{ $role }}</span>
                                        @endforeach
                                        @else
                                        <span>-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#userModal"
                                            data-url="{{ route('users.show', $user->id) }}">
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

    // Modal AJAX pour create/edit
    var userModal = document.getElementById('userModal');

    userModal.addEventListener('show.bs.modal', function(event) {
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
                const pageTitle = modalBody.querySelector('#pageTitle');
                if (pageTitle) {
                    modalTitle.textContent = pageTitle.textContent;
                    pageTitle.remove();
                }
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Impossible de charger le formulaire.</div>';
                console.error(error);
            });
    });
</script>