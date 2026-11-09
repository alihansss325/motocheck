<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f7f9">
    <title>Admin Dashboard · MotoCheck</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin.css">
    <script>window.dashboardData = {{ Illuminate\Support\Js::from($dashboardData) }};</script>
    <script src="/admin.js" defer></script>
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar" id="sidebar">
            <a class="brand" href="/" aria-label="MotoCheck, kembali ke website">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 13.5h2.2l2-4.1h7.6l2 4.1H20M6.2 13.5v2.3h1.7m9.9-2.3v2.3h-1.7M8.2 9.4 9 7.7h6l.8 1.7M7.3 15.8h.1m9.2 0h.1" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.5" cy="15.8" r="1.6" stroke="currentColor" stroke-width="1.7"/><circle cx="16.5" cy="15.8" r="1.6" stroke="currentColor" stroke-width="1.7"/></svg>
                </span>
                <span class="brand-copy"><strong>Moto<span>Check</span></strong><small>CONTROL CENTER</small></span>
            </a>

            <div class="nav-caption">MENU UTAMA</div>
            <nav class="side-nav" aria-label="Navigasi dashboard">
                <button class="nav-link active" type="button" data-view="overview">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="4" rx="1.5"/><rect x="13.5" y="10.5" width="7" height="10" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/></svg>
                    <span>Ringkasan</span>
                </button>
                <button class="nav-link" type="button" data-view="diagnostics">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.2 19 6v5.2c0 4.4-2.8 7.9-7 9.6-4.2-1.7-7-5.2-7-9.6V6l7-2.8Z"/><path d="m9 12 2 2 4-4"/></svg>
                    <span>Riwayat Diagnosa</span><span class="nav-count">08</span>
                </button>
                <button class="nav-link" type="button" data-view="knowledge">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z"/><path d="M4 5.5v16M8 7h8m-8 4h8"/></svg>
                    <span>Basis Pengetahuan</span>
                </button>
                <button class="nav-link" type="button" data-view="catalog">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7.5 12 3l8 4.5-8 4.5-8-4.5Z"/><path d="m4 12 8 4.5 8-4.5M4 16.5 12 21l8-4.5"/></svg>
                    <span>Katalog Servis</span>
                </button>
            </nav>

            <div class="sidebar-bottom">
                <div class="help-card">
                    <span class="help-icon" aria-hidden="true">?</span>
                    <div><strong>Butuh bantuan?</strong><small>Hubungi tim support kami.</small></div>
                    <a href="mailto:support@motocheck.id" aria-label="Hubungi support">↗</a>
                </div>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="sidebar-profile" type="submit" style="width:100%;border:0;background:transparent;text-align:left;cursor:pointer">
                        <span class="avatar avatar-admin">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 2)) }}</span>
                        <span class="profile-copy"><strong>{{ auth()->user()->name }}</strong><small>Administrator · Keluar</small></span>
                        <span class="profile-more" aria-hidden="true">↗</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="main-shell">
            <header class="topbar">
                <button class="icon-button mobile-menu" type="button" id="menu-toggle" aria-label="Buka navigasi" aria-expanded="false">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <div class="breadcrumbs"><a href="/">MotoCheck</a><span>/</span><strong id="breadcrumb-current">Ringkasan</strong></div>
                <div class="topbar-actions">
                    <label class="search-box" for="global-search">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/></svg>
                        <input id="global-search" type="search" placeholder="Cari diagnosa..." autocomplete="off">
                        <kbd>⌘ K</kbd>
                    </label>
                    <button class="icon-button notification-button" type="button" id="notification-button" aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9m-8 12h4"/></svg><i></i>
                    </button>
                    <span class="top-avatar avatar-admin" aria-label="Admin">AD</span>
                </div>
            </header>

            <main class="content">
                <div class="preview-notice">
                    <span class="notice-dot"></span>
                    <span><strong>Dashboard terhubung</strong> · Riwayat dan statistik dari diagnosa yang tersimpan.</span>
                    <button type="button" id="notice-dismiss" aria-label="Tutup pemberitahuan">×</button>
                </div>

                <section class="view-panel active" id="view-overview" aria-labelledby="page-title">
                    <div class="page-heading">
                        <div><p class="eyebrow">OVERVIEW</p><h1 id="page-title">Ringkasan dashboard</h1><p class="page-subtitle">Pantau aktivitas dan performa MotoCheck hari ini.</p></div>
                        <div class="heading-tools">
                            <span class="updated-label"><span class="online-dot"></span> Terakhir diperbarui <strong id="updated-time">—</strong></span>
                            <button class="button button-outline" id="export-button" type="button">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m0 0 4-4m-4 4-4-4M5 17v3h14v-3"/></svg>Ekspor laporan
                            </button>
                        </div>
                    </div>

                    <div class="stats-grid">
                        <article class="stat-card">
                            <div class="stat-top"><span>Total diagnosa</span><span class="stat-icon orange"><svg viewBox="0 0 24 24"><path d="M12 3 19 6v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/></svg></span></div>
                            <div class="stat-number" data-stat="total">{{ number_format($dashboardData['totalDiagnoses'], 0, ',', '.') }}</div><div class="stat-foot"><span class="trend neutral">● Tercatat</span><span>seluruh diagnosa</span></div>
                            <div class="sparkline spark-orange"><svg viewBox="0 0 110 30" preserveAspectRatio="none"><path d="M1 24 15 20 25 22 39 13 51 18 65 9 78 14 92 5 109 8"/></svg></div>
                        </article>
                        <article class="stat-card">
                            <div class="stat-top"><span>Pengguna terdaftar</span><span class="stat-icon blue"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.8 20a6.2 6.2 0 0 1 12.4 0m3-12a3.5 3.5 0 0 1 0 6.8m1 1.7a5 5 0 0 1 2 3.5"/></svg></span></div>
                            <div class="stat-number" data-stat="users">{{ number_format($dashboardData['registeredUsers'], 0, ',', '.') }}</div><div class="stat-foot"><span class="trend neutral">● Akun user</span><span>terdaftar</span></div>
                            <div class="sparkline spark-blue"><svg viewBox="0 0 110 30" preserveAspectRatio="none"><path d="M1 21 14 24 27 15 40 19 53 10 67 15 80 7 94 11 109 3"/></svg></div>
                        </article>
                        <article class="stat-card">
                            <div class="stat-top"><span>Jenis kerusakan</span><span class="stat-icon purple"><svg viewBox="0 0 24 24"><path d="M12 3v3m0 12v3M3 12h3m12 0h3m-2.6-6.4-2.1 2.1M7.7 16.3l-2.1 2.1m12.8 0-2.1-2.1M7.7 7.7 5.6 5.6"/><circle cx="12" cy="12" r="4.3"/></svg></span></div>
                            <div class="stat-number" data-stat="knowledge">{{ $dashboardData['knowledgeItems'] }}</div><div class="stat-foot"><span class="trend neutral">● Tersedia</span><span>basis pengetahuan</span></div>
                            <div class="sparkline spark-purple"><svg viewBox="0 0 110 30" preserveAspectRatio="none"><path d="M1 18 15 18 28 13 42 13 55 17 68 10 81 10 95 6 109 6"/></svg></div>
                        </article>
                        <article class="stat-card">
                            <div class="stat-top"><span>Diagnosa hari ini</span><span class="stat-icon green"><svg viewBox="0 0 24 24"><path d="M4 19V5m0 14h16M8 15l3-4 3 2 5-7"/></svg></span></div>
                            <div class="stat-number" data-stat="today">{{ number_format($dashboardData['todayDiagnoses'], 0, ',', '.') }}</div><div class="stat-foot"><span class="trend neutral">● Hari ini</span><span>diagnosa masuk</span></div>
                            <div class="sparkline spark-green"><svg viewBox="0 0 110 30" preserveAspectRatio="none"><path d="M1 22 15 18 28 20 42 12 55 15 68 8 81 11 95 4 109 6"/></svg></div>
                        </article>
                    </div>

                    <div class="overview-grid">
                        <article class="panel activity-panel">
                            <div class="panel-heading"><div><h2>Aktivitas diagnosa</h2><p>Tren diagnosa selama periode berjalan</p></div><select id="period-select" class="select-control" aria-label="Periode grafik"><option value="7">7 hari terakhir</option><option value="30">30 hari terakhir</option></select></div>
                            <div class="chart-summary"><strong id="chart-total">0</strong><span>total diagnosa</span><span class="trend neutral">7 hari terakhir</span></div>
                            <div class="chart-wrap" role="img" aria-label="Grafik tren aktivitas diagnosa"><div class="chart-y-labels"><span>200</span><span>150</span><span>100</span><span>50</span><span>0</span></div><div class="chart-area"><div class="chart-grid"><i></i><i></i><i></i><i></i><i></i></div><svg id="activity-chart" viewBox="0 0 700 220" preserveAspectRatio="none"><defs><linearGradient id="chart-fill" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#f97316" stop-opacity=".18"/><stop offset="1" stop-color="#f97316" stop-opacity="0"/></linearGradient></defs><path class="chart-fill" d="M0 170 C35 154 48 160 75 140 S120 138 150 126 S196 130 225 102 S270 115 300 94 S345 101 375 86 S420 99 450 72 S495 86 525 60 S570 74 600 50 S650 62 700 24 V220 H0Z"/><path class="chart-line" d="M0 170 C35 154 48 160 75 140 S120 138 150 126 S196 130 225 102 S270 115 300 94 S345 101 375 86 S420 99 450 72 S495 86 525 60 S570 74 600 50 S650 62 700 24"/></svg><div class="chart-x-labels" id="chart-labels"><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span></div></div></div>
                        </article>

                        <article class="panel issues-panel">
                            <div class="panel-heading"><div><h2>Diagnosa teratas</h2><p>Jenis kerusakan paling sering ditemukan</p></div><button class="text-button" type="button" data-go="diagnostics">Lihat semua <span>→</span></button></div>
                            <div class="issue-list" id="top-diagnoses"></div>
                            <div class="issue-foot"><span class="legend-dot"></span> Proporsi dari temuan diagnosa terbaru</div>
                        </article>
                    </div>

                    <article class="panel table-panel">
                        <div class="panel-heading table-heading"><div><h2>Diagnosa terbaru</h2><p>Aktivitas terakhir · maksimal 100 data terbaru</p></div><button class="text-button" type="button" data-go="diagnostics">Lihat semua <span>→</span></button></div>
                        <div class="table-toolbar"><label class="table-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/></svg><input id="table-search" type="search" placeholder="Cari pengguna atau diagnosa..."></label><select class="select-control" id="severity-filter" aria-label="Filter tingkat"><option value="all">Semua tingkat</option><option value="Sedang">Sedang</option><option value="Ringan">Ringan</option><option value="Berat">Berat</option></select></div>
                        <div class="table-scroll"><table><thead><tr><th>PENGGUNA</th><th>HASIL DIAGNOSA</th><th>TINGKAT</th><th>WAKTU</th><th>STATUS</th></tr></thead><tbody id="diagnosis-table"></tbody></table></div>
                        <div class="table-footer"><span id="results-count"></span><button type="button" class="pagination-button" id="show-more">Tampilkan lainnya <span>↓</span></button></div>
                    </article>
                </section>

                <section class="view-panel" id="view-diagnostics" aria-labelledby="diagnostics-title">
                    <div class="page-heading"><div><p class="eyebrow">ANALITIK</p><h1 id="diagnostics-title">Riwayat diagnosa</h1><p class="page-subtitle">Tinjau dan cari aktivitas diagnosa pengguna.</p></div><button class="button button-outline" id="export-button-secondary" type="button"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m0 0 4-4m-4 4-4-4M5 17v3h14v-3"/></svg>Ekspor laporan</button></div>
                    <div class="stats-grid compact-stats"><article class="stat-card"><div class="stat-top"><span>Total diagnosa</span><span class="stat-icon orange"><svg viewBox="0 0 24 24"><path d="M12 3 19 6v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6l7-3Z"/></svg></span></div><div class="stat-number" data-stat="total">{{ number_format($dashboardData['totalDiagnoses'], 0, ',', '.') }}</div><div class="stat-foot"><span class="trend neutral">● Tercatat</span><span>semua waktu</span></div></article><article class="stat-card"><div class="stat-top"><span>Diagnosa hari ini</span><span class="stat-icon blue"><svg viewBox="0 0 24 24"><path d="M4 19V5m0 14h16M8 15l3-4 3 2 5-7"/></svg></span></div><div class="stat-number" data-stat="today">{{ number_format($dashboardData['todayDiagnoses'], 0, ',', '.') }}</div><div class="stat-foot"><span class="trend neutral">● Hari ini</span><span>diagnosa masuk</span></div></article><article class="stat-card"><div class="stat-top"><span>Pengguna terdaftar</span><span class="stat-icon amber"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.8 20a6.2 6.2 0 0 1 12.4 0m3-12a3.5 3.5 0 0 1 0 6.8"/></svg></span></div><div class="stat-number" data-stat="users">{{ number_format($dashboardData['registeredUsers'], 0, ',', '.') }}</div><div class="stat-foot"><span class="trend neutral">● Akun user</span><span>terdaftar</span></div></article><article class="stat-card"><div class="stat-top"><span>Jenis kerusakan</span><span class="stat-icon green"><svg viewBox="0 0 24 24"><path d="M12 3v3m0 12v3M3 12h3m12 0h3m-2.6-6.4-2.1 2.1M7.7 16.3l-2.1 2.1m12.8 0-2.1-2.1M7.7 7.7 5.6 5.6"/><circle cx="12" cy="12" r="4.3"/></svg></span></div><div class="stat-number" data-stat="knowledge">{{ $dashboardData['knowledgeItems'] }}</div><div class="stat-foot"><span class="trend neutral">● Tersedia</span><span>basis pengetahuan</span></div></article></div>
                    <article class="panel table-panel full-table"><div class="panel-heading"><div><h2>Semua aktivitas</h2><p>Daftar riwayat diagnosa pengguna</p></div><span class="demo-tag">DATA TERSIMPAN</span></div><div class="table-toolbar"><label class="table-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5"/></svg><input id="diagnostics-search" type="search" placeholder="Cari pengguna atau diagnosa..."></label><select class="select-control" id="diagnostics-filter" aria-label="Filter tingkat"><option value="all">Semua tingkat</option><option value="Sedang">Sedang</option><option value="Ringan">Ringan</option><option value="Berat">Berat</option></select></div><div class="table-scroll"><table><thead><tr><th>PENGGUNA</th><th>HASIL DIAGNOSA</th><th>TINGKAT</th><th>WAKTU</th><th>STATUS</th></tr></thead><tbody id="all-diagnosis-table"></tbody></table></div><div class="table-footer"><span id="all-results-count"></span><span>Riwayat diagnosa tersimpan</span></div></article>
                </section>

                <section class="view-panel" id="view-knowledge" aria-labelledby="knowledge-title">
                    <div class="page-heading"><div><p class="eyebrow">KONFIGURASI</p><h1 id="knowledge-title">Basis pengetahuan</h1><p class="page-subtitle">Referensi kerusakan yang digunakan sistem pakar.</p></div><span class="demo-tag">HANYA TAMPILAN</span></div>
                    <div class="knowledge-callout"><span class="callout-icon">i</span><p><strong>Konten ini belum terhubung ke basis pengetahuan aplikasi.</strong> Perubahan diagnosa pada halaman ini belum memengaruhi hasil diagnosa pengguna.</p></div>
                    <div class="knowledge-grid" id="knowledge-grid"></div>
                </section>

                <section class="view-panel" id="view-catalog" aria-labelledby="catalog-title">
                    <div class="page-heading"><div><p class="eyebrow">KONTEN WEBSITE</p><h1 id="catalog-title">Katalog servis</h1><p class="page-subtitle">Ringkasan rekomendasi servis yang tersedia di halaman publik.</p></div><a class="button button-primary" href="/#tab-katalog">Lihat katalog publik <span>↗</span></a></div>
                    <div class="catalog-summary"><div class="catalog-summary-icon"><svg viewBox="0 0 24 24"><path d="m4 7.5 8-4.5 8 4.5-8 4.5-8-4.5Zm0 4.5 8 4.5 8-4.5M4 16.5 12 21l8-4.5"/></svg></div><div><strong>5 rekomendasi servis</strong><p>Informasi servis dan interval perawatan dapat dilihat di katalog publik.</p></div></div>
                    <div class="catalog-grid">
                        <article class="catalog-card"><span class="catalog-icon orange"><svg viewBox="0 0 24 24"><path d="M12 3v18m-5-14h8a3 3 0 0 1 0 6H9a3 3 0 0 0 0 6h8"/></svg></span><div><small>MESIN & PELUMASAN</small><h3>Oli Mesin</h3><p>Ganti setiap 2.000–2.500 KM</p></div><span class="catalog-status">Aktif</span></article>
                        <article class="catalog-card"><span class="catalog-icon blue"><svg viewBox="0 0 24 24"><path d="M8 3h8v3l2 2v10l-2 3H8l-2-3V8l2-2V3Z"/><path d="M8 6h8m-8 13h8"/></svg></span><div><small>SISTEM PENGAPIAN</small><h3>Busi Motor</h3><p>Periksa setiap 8.000–10.000 KM</p></div><span class="catalog-status">Aktif</span></article>
                        <article class="catalog-card"><span class="catalog-icon purple"><svg viewBox="0 0 24 24"><path d="M12 3v18m-7-7 7 7 7-7"/></svg></span><div><small>TRANSMISI</small><h3>V-Belt CVT</h3><p>Periksa setiap 20.000–25.000 KM</p></div><span class="catalog-status">Aktif</span></article>
                        <article class="catalog-card"><span class="catalog-icon green"><svg viewBox="0 0 24 24"><path d="M5 6h14M5 12h14M5 18h14M8 4v4m8 2v4m-5 2v4"/></svg></span><div><small>SISTEM PENGEREMAN</small><h3>Kampas Rem</h3><p>Periksa setiap 8.000–12.000 KM</p></div><span class="catalog-status">Aktif</span></article>
                        <article class="catalog-card"><span class="catalog-icon amber"><svg viewBox="0 0 24 24"><path d="M4 4h16v16H4zM8 8h8m-8 4h8m-8 4h5"/></svg></span><div><small>MESIN & PELUMASAN</small><h3>Filter Udara</h3><p>Bersihkan / ganti setiap 15.000 KM</p></div><span class="catalog-status">Aktif</span></article>
                    </div>
                </section>

                <footer class="page-footer"><span>© 2026 MotoCheck · Control Center</span><span><span class="footer-dot"></span> Semua sistem beroperasi</span></footer>
            </main>
        </div>
    </div>
    <div class="toast" id="toast" role="status" aria-live="polite"></div>
</body>
</html>
