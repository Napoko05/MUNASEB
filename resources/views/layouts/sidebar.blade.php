<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    
    <!-- Logo -->
    <div class="m-header">
      <a href="{{ url('/home') }}" class="b-brand text-primary">
        <img src="{{ asset('storage/assets/images/logo-white.svg') }}" alt="logo" class="logo-lg" />
      </a>
    </div>

    <!-- Sidebar Content -->
    <div class="navbar-content">
      <ul class="pc-navbar">

        <!-- Si utilisateur non connecté -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
          @endif
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
          @endif
        @else

          <!-- Tableau de bord -->
          <li class="pc-item">
            <a href="{{ url('/home') }}" class="pc-link">
              <span class="pc-micon"><i class="ph ph-gauge"></i></span>
              <span class="pc-mtext">Tableau de bord</span>
            </a>
          </li>

          <!-- Mon agenda -->
          <li class="pc-item">
            <a href="#" class="pc-link">
              <span class="pc-micon"><i class="ph ph-calendar"></i></span>
              <span class="pc-mtext">Mon agenda</span>
            </a>
          </li> 

          <!-- Section Administration (visible uniquement Admin) -->
          @role('Admin')
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">
                <span class="pc-micon"><i class="ph ph-gear"></i></span>
                <span class="pc-mtext">Administration</span>
                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
              </a>
              <ul class="pc-submenu">
                <li class="pc-item">
                  <a href="{{ route('users.index') }}" class="pc-link">
                    <i class="ph ph-user"></i> Gestion des utilisateurs
                  </a>
                </li>
                <li class="pc-item">
                  <a href="{{ route('roles.index') }}" class="pc-link">
                    <i class="ph ph-shield"></i> Gestion des rôles
                  </a>
                </li>
              </ul>
            </li>
          @endrole

          
        @endguest
      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->

<!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="m-header">
    <a href="{{ url('/home') }}" class="b-brand text-primary">
      <img src="{{ asset('storage/assets/images/logo-white.svg') }}" alt="logo" class="logo-lg" />
    </a>
  </div>

  <div class="header-wrapper">
    <!-- Menu mobile -->
    <div class="me-auto pc-mob-drp">
      <ul class="list-unstyled">
        <li class="pc-h-item pc-sidebar-collapse">
          <a href="#" class="pc-head-link ms-0" id="sidebar-hide"><i class="ph ph-list"></i></a>
        </li>
        <li class="pc-h-item pc-sidebar-popup">
          <a href="#" class="pc-head-link ms-0" id="mobile-collapse"><i class="ph ph-list"></i></a>
        </li>
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#">
            <i class="ph ph-magnifying-glass"></i>
          </a>
          <div class="dropdown-menu pc-h-dropdown drp-search">
            <form class="px-3">
              <div class="form-group d-flex align-items-center mb-0">
                <input type="search" class="form-control border-0 shadow-none" placeholder="Recherche..." />
                <button class="btn btn-light-secondary btn-search">OK</button>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </div>

    <!-- Profil utilisateur -->
    <div class="ms-auto">
      <ul class="list-unstyled">
        <li class="dropdown pc-h-item header-user-profile">
          <a class="pc-head-link dropdown-toggle me-0" data-bs-toggle="dropdown" href="#">
            <img src="{{ asset('storage/assets/images/user/avatar-2.jpg') }}" alt="user" class="user-avtar" />
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown" style="min-width:200px;">
            <div class="dropdown-body">
              <ul class="list-group list-group-flush">

                <li class="list-group-item d-flex justify-content-between align-items-center">
                  {{ Auth::user()->name }}
                  <span class="badge rounded-pill bg-success">
                    {{ Auth::user()->roles->first()->name ?? '' }}
                  </span>
                </li>

                <li class="list-group-item">
                  <a href="#" class="dropdown-item">
                    <i class="ph ph-user-circle me-2"></i> Éditer profil
                  </a>
                </li>

                <li class="list-group-item">
                  <a href="{{ route('logout') }}" class="dropdown-item"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ph ph-power me-2"></i> Déconnexion
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>

              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</header>
<!-- [ Header ] end -->
