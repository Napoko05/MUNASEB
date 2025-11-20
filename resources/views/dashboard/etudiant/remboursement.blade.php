@extends($layouts.app)

@section('toolbar')
<div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-white fw-bold my-1 fs-3">GESTION DES BONS</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-white opacity-75">
                    <a href="index.html" class="text-white text-hover-primary">Accueil</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-white opacity-75">Gestion des remboursements</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-white opacity-75">Liste des remboursements</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>
@endsection

@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" dt-bon-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <button disabled type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
                            <i class="ki-duotone ki-filter fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i> Parametre de recherche
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <table class="table table-hover table-striped table-bottom-line" data-consult-url = '{{ url("remboursement/remboursement_view") }}' data-edit-url='{{ url("remboursement/remboursement_edit") }}' data-delete-url='{{ url("remboursement/remboursement_delete") }}' data-url='{{ url("remboursement/remboursement_datatable_liste") }}'   id="dt_remboursement">
                    <thead class="thead-app">
                        <tr>
                            <th class="w-80px text-center">#</th>
                            <th class="w-120px text-uppercase">{{ __('remboursement.numremb') }}</th>
                            <th class="text-uppercase">{{ __('remboursement.datedmd') }}</th>
                            <th class="text-uppercase">{{ __('remboursement.agence') }}</th>
                            <th class="text-uppercase none">{{ __('remboursement.observation') }}</th>
                            <th class="text-uppercase none">{{ __('remboursement.etp') }}</th>
                            <th class="text-uppercase none">{{ __('remboursement.mntpartetu') }}</th>
                            <th class="text-uppercase none">{{ __('remboursement.mntpartcenou') }}</th>
                            <th class="text-uppercase text-end">{{ __('remboursement.mnttotal') }}</th>
                            <th class="text-center text-uppercase all min-w-50px">{{ __('remboursement.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class=""></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/pages/munaseb/espaceadherent/remboursement_liste.js?v=1') }}"></script>
@endsection