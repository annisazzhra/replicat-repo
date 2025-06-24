<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Hotspot Vigilance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/sass/app.scss')
</head>
<body>
    <div class="form-container">
        <div class="logo">
            <img src="{{ asset('images/hotspot_vigilance_logo.png') }}" alt="Hotspot Vigilance Logo" class="img-fluid">
            <h3>Hotspot Vigilance</h3>
        </div>

        <p class="text-muted mb-4">Silahkan masukkan detail registrasi Anda</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Alamat email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="phone_number" class="form-label">Nomor telp</label>
                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel">
                @error('phone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Buat password</label>
                <div class="input-group input-group-password">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                        <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 text-start">
                <label for="password_confirmation" class="form-label">Konfirmasi password</label>
                <div class="input-group input-group-password">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordConfirmationIcon')">
                        <i class="fa fa-eye-slash" id="togglePasswordConfirmationIcon"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3 form-check text-start">
                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                <label class="form-check-label" for="terms">Menerima syarat dan ketentuan pengguna</label>
                @error('terms')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Daftar</button>
        </form>

        <p class="mt-4 text-center">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-decoration-none">masuk</a>
        </p>

        <div class="mt-5 text-center">
            <a href="{{ route('home') }}" class="btn btn-link text-decoration-none">
                <img src="{{ asset('images/back_icon.png') }}" alt="Kembali ke Beranda" style="width: 20px; vertical-align: middle; margin-right: 5px;"> Kembali ke Beranda
            </a>
        </div>
    </div>
    @vite('resources/js/app.js')
    <script>
        function togglePasswordVisibility(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const togglePasswordIcon = document.getElementById(iconId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>