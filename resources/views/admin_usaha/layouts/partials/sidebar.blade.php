<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->routeIs('admin_usaha.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_usaha.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin_usaha.lowongan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_usaha.lowongan.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Lowongan Kerja</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin_usaha.lamaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_usaha.lamaran.index') }}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Data Pelamar</span>
            </a>
        </li>


    </ul>
</nav>
