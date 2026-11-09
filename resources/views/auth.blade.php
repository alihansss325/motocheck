<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f7f9">
    <title>{{ $mode === 'login' ? 'Masuk' : 'Daftar' }} · MotoCheck</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/auth.css">
</head>
<body>
    <main class="auth-shell">
        <section class="auth-card" aria-labelledby="auth-title">
            <a class="auth-brand" href="/" aria-label="MotoCheck, kembali ke beranda">
                <span class="brand-icon" aria-hidden="true">M</span>
                <span>Moto<span>Check</span></span>
            </a>
            <p class="auth-eyebrow">AKUN MOTOCHECK</p>
            <h1 id="auth-title">{{ $mode === 'login' ? 'Selamat datang kembali' : 'Buat akun baru' }}</h1>
            <p class="auth-description">{{ $mode === 'login' ? 'Masuk untuk melihat riwayat diagnosa dan mengelola akun Anda.' : 'Daftar sebagai pengguna untuk menyimpan dan melihat riwayat diagnosa.' }}</p>

            @if (session('status'))
                <div class="auth-success" role="status">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="auth-error" role="alert">
                    <strong>Mohon periksa kembali data Anda.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ $mode === 'login' ? route('login') : route('register') }}" class="auth-form">
                @csrf
                @if ($mode === 'register')
                    <label for="name">Nama lengkap</label>
                    <input id="name" name="name" value="{{ old('name') }}" type="text" autocomplete="name" maxlength="120" required autofocus>
                @endif
                <label for="email">Email</label>
                <input id="email" name="email" value="{{ old('email') }}" type="email" autocomplete="email" maxlength="255" required @if ($mode === 'login') autofocus @endif>
                <label for="password">Kata sandi</label>
                <input id="password" name="password" type="password" autocomplete="{{ $mode === 'login' ? 'current-password' : 'new-password' }}" required @if ($mode === 'register') minlength="10" @endif>
                @if ($mode === 'login')
                    <label class="remember-row"><input type="checkbox" name="remember" value="1"> <span>Ingat saya</span></label>
                @else
                    <label for="password_confirmation">Ulangi kata sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="10" required>
                    <p class="field-note">Gunakan minimal 10 karakter. Semua pendaftaran mendapatkan akses pengguna, bukan admin.</p>
                @endif
                <button class="auth-submit" type="submit">{{ $mode === 'login' ? 'Masuk' : 'Buat akun' }}</button>
            </form>

            <p class="auth-switch">
                {{ $mode === 'login' ? 'Belum punya akun?' : 'Sudah punya akun?' }}
                <a href="{{ $mode === 'login' ? route('register') : route('login') }}">{{ $mode === 'login' ? 'Daftar sekarang' : 'Masuk' }}</a>
            </p>
            <a class="back-link" href="/">← Kembali ke MotoCheck</a>
        </section>
        <p class="auth-footer">© 2026 MotoCheck · Sistem Pakar Diagnosa Sepeda Motor</p>
    </main>
</body>
</html>
