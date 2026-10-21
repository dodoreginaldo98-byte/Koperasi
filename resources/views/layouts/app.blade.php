<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KoperasiKu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">KoperasiKu</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarMenu" aria-controls="navbarMenu"
                    aria-expanded="false" aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    @if (Route::has('anggota.index'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}"
                               href="{{ route('anggota.index') }}">Data Anggota</a>
                        </li>
                    @endif

                    @if (Route::has('simpanan.index'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('simpanan.*') ? 'active' : '' }}"
                               href="{{ route('simpanan.index') }}">Simpanan</a>
                        </li>
                    @endif

                    @if (auth()->user()?->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">Manajemen User</a>
                        </li>
                    @endif
                </ul>

                @auth
                    <span class="navbar-text text-white me-3">
                        {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4">
        <small>&copy; {{ date('Y') }} KoperasiKu - Reginaldo Almubi Jukris</small>
    </footer>
</body>
</html>