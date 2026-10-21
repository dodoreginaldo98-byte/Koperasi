<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login') - KoperasiKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="w-100 px-3" style="max-width: 420px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary mb-0">KoperasiKu</h2>
                <small class="text-muted">Aplikasi Koperasi Simpan Pinjam</small>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>