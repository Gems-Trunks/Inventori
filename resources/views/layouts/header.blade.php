<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Inventaris</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css" />

    <link rel="stylesheet" href="{{ asset('asset/css/sidebar-costum.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/element-costum.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- script theme --}}
    <script>
        (() => {
            "use strict";

            let stored = null;
            try {
                stored = localStorage.getItem("lte-theme");
            } catch {}

            const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const resolved =
                stored === "dark" || stored === "light" ?
                stored :
                (prefersDark ? "dark" : "light");

            document.documentElement.setAttribute("data-bs-theme", resolved);
            document.documentElement.style.colorScheme = resolved;
        })();
    </script>

    {{-- theme Mode --}}
</head>

<body class="sidebar-mini">
    <div class="app-wrapper">

        <!-- Header -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>

                {{-- profile drop down --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown dropdown-center">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="d-flex justify-content-center text-center">
                                <p class="bold text-body">Halo,
                                    {{ Auth::user()->nama }}</p>
                            </li>
                            <li class="d-flex justify-content-center text-center mb-3 btn btn-outline-warning btn-no-hover">
                                @auth
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                        data-bs-id="{{ auth()->user()->id }}" data-bs-nama="{{ Auth::user()->nama }}"
                                        data-bs-nrp="{{ auth()->user()->nrp }}"
                                        data-bs-password="{{ auth()->user()->password }}"
                                        data-bs-url="{{ route('users.update', auth()->user()->id) }}"
                                        class="text-warning outline-warning" href="#">Edit Profil</button>
                                @endauth

                            </li>
                            <li class="d-flex justify-content-center btn btn-outline-danger btn-no-hover">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="text-danger outline-danger" type="button" onclick="logoutAlert()"><i
                                            class="bi bi-power"></i>Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    {{-- theme mode drop down --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="bd-theme" aria-label="Toggle color scheme"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
                            <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
                            <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="light" aria-pressed="false">
                                    <i class="bi bi-sun-fill me-2"></i> Light
                                    <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="dark" aria-pressed="false">
                                    <i class="bi bi-moon-fill me-2"></i> Dark
                                    <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                            <li>

                                <button type="button" class="dropdown-item d-flex align-items-center active"
                                    data-bs-theme-value="auto" aria-pressed="true">
                                    <i class="bi bi-circle-half me-2"></i> Auto
                                    <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- modal  --}}
        @auth

            <x-modal-profile></x-modal-profile>
        @endauth
        <script>
            function logoutAlert() {
                window.Swal.fire({
                    title: 'Yakin ingin keluar?',
                    text: 'Konfirmasi ingin keluar',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Logout',
                    cancelButtonText: 'Batal',
                    showClass: {
                        popup: `
      animate__animated
      animate__fadeInDown
      animate__faster
    `
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            }
        </script>
