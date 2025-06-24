<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotspot Vigilance - Beranda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/sass/app.scss')
</head>
<body>
    <div class="landing-container d-flex flex-column justify-content-center align-items-center">
        <div class="landing-logo">
            <img src="{{ asset('images/hotspot_vigilance_logo.png') }}" alt="Hotspot Vigilance Logo" class="img-fluid">
            <h3>Hotspot Vigilance</h3>
        </div>
        <p class="tagline">
            Deteksi Dini, Tindakan Cepat.
        </p>
        <p class="description">
            Hotspot Vigilance berfungsi untuk memantau titik panas (hotspot) secara real-time di seluruh desa di Provinsi Sumatera Selatan melalui peta interaktif, guna mendukung mitigasi kebakaran hutan dan lahan secara lebih cepat dan tepat.
        </p>
        <div class="action-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar</a>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>