<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f7f9">
    <title>Akun Saya · MotoCheck</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/auth.css">
</head>
<body>
    @php
        $settingsTabActive = session()->has('status')
            || $errors->profile->any()
            || $errors->password->any()
            || $errors->deleteAccount->any();
    @endphp
    <main class="account-shell">
        <header class="account-header">
            <a class="auth-brand" href="/"><span class="brand-icon" aria-hidden="true">M</span><span>Moto<span>Check</span></span></a>
            <a class="account-back-link" href="/">← Kembali ke beranda</a>
        </header>
        <section class="account-card">
            <div class="account-heading">
                <div><p class="auth-eyebrow">AKUN SAYA</p><h1>Halo, {{ auth()->user()->name }}</h1><p class="auth-description">{{ auth()->user()->email }} · Pengguna</p></div>
                <form method="post" action="{{ route('logout') }}">@csrf<button class="logout-button" type="submit">Keluar</button></form>
            </div>
            <div class="account-tabs" role="tablist" aria-label="Menu akun">
                <button id="history-tab" class="account-tab{{ $settingsTabActive ? '' : ' is-active' }}" type="button" role="tab" aria-controls="history-panel" aria-selected="{{ $settingsTabActive ? 'false' : 'true' }}" tabindex="{{ $settingsTabActive ? '-1' : '0' }}" data-tab="history">Riwayat diagnosa</button>
                <button id="settings-tab" class="account-tab{{ $settingsTabActive ? ' is-active' : '' }}" type="button" role="tab" aria-controls="settings-panel" aria-selected="{{ $settingsTabActive ? 'true' : 'false' }}" tabindex="{{ $settingsTabActive ? '0' : '-1' }}" data-tab="settings">Pengaturan akun</button>
            </div>
            <section id="history-panel" class="account-tab-panel" role="tabpanel" aria-labelledby="history-tab" tabindex="0" @if ($settingsTabActive) hidden @endif>
                <div class="account-section-title"><div><h2>Riwayat diagnosa</h2><p>Diagnosa saat masuk ke akun ini · maksimal 20 terbaru.</p></div><a href="/#tab-diagnosa">Mulai diagnosa →</a></div>
                @if ($diagnoses->isEmpty())
                    <div class="account-empty"><strong>Belum ada riwayat diagnosa</strong><p>Hasil diagnosa Anda akan muncul di sini setelah tersimpan.</p><a class="auth-submit empty-action" href="/#tab-diagnosa">Mulai diagnosa</a></div>
                @else
                    <div class="account-history">
                        @foreach ($diagnoses as $diagnosis)
                            <article class="history-row">
                                <span class="history-severity {{ strtolower($diagnosis->severity) }}">{{ $diagnosis->severity }}</span>
                                <div><strong>{{ implode(', ', $diagnosis->symptoms) }}</strong><small>{{ $diagnosis->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</small></div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
            <section id="settings-panel" class="account-tab-panel" role="tabpanel" aria-labelledby="settings-tab" tabindex="0" @unless ($settingsTabActive) hidden @endunless>
                @if (session('status'))
                    <div class="auth-success account-status" role="status">{{ session('status') }}</div>
                @endif
                <section class="account-settings" aria-labelledby="account-settings-title">
                    <div class="account-section-title"><div><h2 id="account-settings-title">Pengaturan akun</h2><p>Kelola informasi dan keamanan akun Anda.</p></div></div>
                    <article class="settings-section">
                        <h3>Informasi profil</h3>
                        <p class="settings-description">Perbarui nama dan alamat email yang terhubung ke akun.</p>
                        @if ($errors->profile->any())
                            <div class="auth-error" role="alert"><ul>@foreach ($errors->profile->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <form method="post" action="{{ route('account.profile.update') }}" class="settings-form">
                            @csrf
                            @method('PATCH')
                            <label for="profile-name">Nama</label>
                            <input id="profile-name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" maxlength="120" autocomplete="name" required>
                            <label for="profile-email">Email</label>
                            <input id="profile-email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" maxlength="255" autocomplete="email" required>
                            <button class="settings-submit" type="submit">Simpan profil</button>
                        </form>
                    </article>
                    <article class="settings-section">
                        <h3>Ganti kata sandi</h3>
                        <p class="settings-description">Gunakan kata sandi minimal 10 karakter.</p>
                        @if ($errors->password->any())
                            <div class="auth-error" role="alert"><ul>@foreach ($errors->password->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <form method="post" action="{{ route('account.password.update') }}" class="settings-form">
                            @csrf
                            @method('PUT')
                            <label for="current-password">Kata sandi saat ini</label>
                            <input id="current-password" name="current_password" type="password" autocomplete="current-password" required>
                            <label for="new-password">Kata sandi baru</label>
                            <input id="new-password" name="password" type="password" autocomplete="new-password" minlength="10" required>
                            <label for="new-password-confirmation">Ulangi kata sandi baru</label>
                            <input id="new-password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="10" required>
                            <button class="settings-submit" type="submit">Ganti kata sandi</button>
                        </form>
                    </article>
                    <article class="settings-section danger-section">
                        <h3>Hapus akun</h3>
                        <p class="settings-description">Akun dan semua riwayat diagnosa milik Anda akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
                        @if ($errors->deleteAccount->any())
                            <div class="auth-error" role="alert"><ul>@foreach ($errors->deleteAccount->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <form method="post" action="{{ route('account.destroy') }}" class="settings-form">
                            @csrf
                            @method('DELETE')
                            <label for="delete-current-password">Kata sandi saat ini</label>
                            <input id="delete-current-password" name="current_password" type="password" autocomplete="current-password" required>
                            <label class="confirm-delete"><input type="checkbox" name="confirm_delete" value="1" required> Saya mengerti bahwa akun dan riwayat diagnosa akan dihapus permanen.</label>
                            <button class="danger-button" type="submit">Hapus akun saya</button>
                        </form>
                    </article>
                </section>
            </section>
        </section>
        <p class="auth-footer">© 2026 MotoCheck · Riwayat diagnosa hanya terlihat oleh akun Anda dan admin.</p>
    </main>
    <script>
        const accountTabs = [...document.querySelectorAll('[role="tab"][data-tab]')];

        function activateAccountTab(tab, moveFocus = false) {
            accountTabs.forEach((item) => {
                const isActive = item === tab;
                item.classList.toggle('is-active', isActive);
                item.setAttribute('aria-selected', String(isActive));
                item.tabIndex = isActive ? 0 : -1;
                document.getElementById(item.getAttribute('aria-controls')).hidden = !isActive;
            });

            if (moveFocus) tab.focus();
        }

        accountTabs.forEach((tab, index) => {
            tab.addEventListener('click', () => activateAccountTab(tab));
            tab.addEventListener('keydown', (event) => {
                let nextIndex;
                if (event.key === 'ArrowRight') nextIndex = (index + 1) % accountTabs.length;
                if (event.key === 'ArrowLeft') nextIndex = (index - 1 + accountTabs.length) % accountTabs.length;
                if (event.key === 'Home') nextIndex = 0;
                if (event.key === 'End') nextIndex = accountTabs.length - 1;
                if (nextIndex !== undefined) {
                    event.preventDefault();
                    activateAccountTab(accountTabs[nextIndex], true);
                }
            });
        });
    </script>
</body>
</html>
