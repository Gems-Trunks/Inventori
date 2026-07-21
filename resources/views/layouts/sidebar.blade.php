<aside class="app-sidebar shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <span class="brand-text fw-light">Inventori</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                <li class="nav-item ">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p class="sidebar-link">Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('bukuTamu') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-book"></i>
                        <p class="sidebar-link">Buku Tamu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('inventaris') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p class="sidebar-link">Inventaris</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon bi bi-file-earmark-text  "></i>
                        <p class="sidebar-link">Inspeksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('config') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p class="sidebar-link">Config</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
