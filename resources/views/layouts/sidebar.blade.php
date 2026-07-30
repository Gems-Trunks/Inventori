<aside class="app-sidebar shadow" data-bs-theme="dark">
    <div>
        <div class="sidebar-brand">
            <a href="#" class="brand-link">
                <img src="{{ asset('asset/images/logos/logo_ppa.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-white-border opacity-100 shadow" />
                <span class="brand-text fw-bold">PUTRA PERKASA ABADI</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p class="sidebar-link">Dashboard</p>
                        </a>
                    </li>

                    <!-- Buku Tamu -->
                    <li class="nav-item">
                        <a href="{{ route('tamu.index') }}"
                            class="nav-link {{ request()->routeIs('tamu.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-book"></i>
                            <p class="sidebar-link">Buku Tamu</p>
                        </a>
                    </li>

                    <!-- Inventaris -->
                    <li class="nav-item">
                        <a href="{{ route('inventaris.index') }}"
                            class="nav-link {{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam"></i>
                            <p class="sidebar-link">Inventaris</p>
                        </a>
                    </li>

                    <!-- Menu Dropdown Inspeksi -->
                    <li class="nav-item {{ request()->routeIs('inspeksi.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('inspeksi.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-tools"></i>
                            <p>
                                Inspeksi
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('inspeksi.stavolt.index') }}"
                                    class="nav-link {{ request()->routeIs('inspeksi.stavolt.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Inspeksi Stavolt</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('inspeksi.ups.index') }}"
                                    class="nav-link {{ request()->routeIs('inspeksi.ups.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Inspeksi UPS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('inspeksi.monitor.index') }}"
                                    class="nav-link {{ request()->routeIs('inspeksi.monitor.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Inspeksi Monitor/Tv</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../index3.html" class="nav-link">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Inspeksi CCTV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('inspeksi.proyektor.index') }}"
                                    class="nav-link {{ request()->routeIs('inspeksi.proyektor.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Inspeksi Proyektor</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Config -->
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->routeIs('config') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-gear"></i>
                            <p class="sidebar-link">Config</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</aside>
