<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotoCheck — Sistem Pakar Diagnosa Motor</title>
    <meta name="description" content="Diagnosa kerusakan sepeda motor secara mandiri sebelum ke bengkel. Hemat biaya, hindari overcharging.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { inter: ['Inter', 'sans-serif'] },
                    colors: { primary: '#f97316' }
                }
            }
        }
    </script>
</head>
<body class="font-inter bg-slate-900 text-slate-100 antialiased min-h-screen">

    <!-- ================================================================ -->
    <!-- NAVBAR                                                            -->
    <!-- ================================================================ -->
    <nav class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md border-b border-slate-700/60 shadow-lg shadow-slate-900/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <button onclick="switchTab('home')" class="flex items-center space-x-2.5 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-md shadow-orange-500/30 transition-transform group-hover:scale-105">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-lg font-black text-white tracking-tight">MotoCheck</span>
                        <span class="text-[10px] font-medium text-orange-400 tracking-widest uppercase">Sistem Pakar</span>
                    </div>
                </button>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1.5 bg-slate-800/60 p-1.5 rounded-2xl border border-slate-700/50">
                    <button id="nav-btn-home" onclick="switchTab('home')"
                        class="tab-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-2 bg-orange-500 text-white shadow-md shadow-orange-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Beranda</span>
                    </button>
                    <button id="nav-btn-diagnosa" onclick="switchTab('diagnosa')"
                        class="tab-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-2 text-slate-300 hover:text-white hover:bg-slate-700/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <span>Diagnosa</span>
                    </button>
                    <button id="nav-btn-katalog" onclick="switchTab('katalog')"
                        class="tab-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-2 text-slate-300 hover:text-white hover:bg-slate-700/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Katalog Servis</span>
                    </button>
                </div>

                <!-- Mobile menu button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700/50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-1 border-t border-slate-700/50 pt-3 mt-1">
                <button id="mobile-nav-home" onclick="switchTab('home')"
                    class="w-full text-left px-4 py-3 rounded-xl font-semibold text-sm bg-orange-500 text-white">
                    🏠 Beranda
                </button>
                <button id="mobile-nav-diagnosa" onclick="switchTab('diagnosa')"
                    class="w-full text-left px-4 py-3 rounded-xl font-medium text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                    🔍 Diagnosa Interaktif
                </button>
                <button id="mobile-nav-katalog" onclick="switchTab('katalog')"
                    class="w-full text-left px-4 py-3 rounded-xl font-medium text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors">
                    📋 Katalog Servis
                </button>
            </div>
        </div>
    </nav>

    <!-- ================================================================ -->
    <!-- MAIN CONTENT                                                      -->
    <!-- ================================================================ -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <!-- ============================================================ -->
        <!-- TAB 1: BERANDA / HOME                                        -->
        <!-- ============================================================ -->
        <div id="tab-home" class="tab-content opacity-100 transition-opacity duration-300">

            <!-- Hero Banner -->
            <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-800 via-slate-800/95 to-slate-900 border border-slate-700/60 p-8 sm:p-12 md:p-16 mb-8 shadow-2xl">
                <!-- Dekorasi latar -->
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-orange-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-8 -left-8 w-48 h-48 bg-orange-500/5 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative max-w-2xl">
                    <!-- Badge kecil -->
                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-orange-500/15 border border-orange-500/30 mb-6">
                        <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <span class="text-xs font-bold text-orange-400 tracking-wide uppercase">Sistem Pakar Diagnosa Motor</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white leading-tight tracking-tight mb-4">
                        Ketahui Kerusakan Motormu
                        <span class="text-orange-400 block mt-1">Sebelum ke Bengkel!</span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-8 max-w-lg">
                        Diagnosa gejala kerusakan motor secara mandiri. Pahami masalah dan estimasi biaya agar kamu tidak kena <strong class="text-orange-300 font-semibold">overcharging</strong> di bengkel.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <button onclick="switchTab('diagnosa')"
                            class="inline-flex items-center space-x-2 px-6 py-3 bg-orange-500 hover:bg-orange-400 active:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-500/30 transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            <span>Mulai Diagnosa Sekarang</span>
                        </button>
                        <button onclick="switchTab('katalog')"
                            class="inline-flex items-center space-x-2 px-6 py-3 bg-slate-700 hover:bg-slate-600 active:bg-slate-800 text-slate-100 font-semibold rounded-2xl border border-slate-600/70 transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Cek Jadwal Servis</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Fitur Unggulan -->
            <section>
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">Fitur Unggulan</h2>
                    <p class="text-slate-400 text-sm">Semua yang kamu butuhkan untuk merawat motor dengan cerdas.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Kartu 1 -->
                    <div class="group bg-slate-800/80 border border-slate-700/60 hover:border-orange-500/50 rounded-3xl p-6 sm:p-7 shadow-lg hover:shadow-orange-500/10 transition-all duration-300 cursor-pointer" onclick="switchTab('diagnosa')">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center mb-5 group-hover:bg-orange-500/25 transition-colors">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Diagnosa Interaktif</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Pilih gejala yang dialami motor, sistem pakar kami akan menganalisis dan mengidentifikasi kemungkinan kerusakan secara otomatis.</p>
                        <div class="mt-4 flex items-center text-orange-400 text-sm font-semibold group-hover:translate-x-1 transition-transform">
                            <span>Mulai Diagnosa</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>

                    <!-- Kartu 2 -->
                    <div class="group bg-slate-800/80 border border-slate-700/60 hover:border-emerald-500/50 rounded-3xl p-6 sm:p-7 shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center mb-5 group-hover:bg-emerald-500/25 transition-colors">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Keputusan Penggantian</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Setiap hasil analisis menampilkan keputusan jelas: apakah sparepart <strong class="text-emerald-400">perlu diganti</strong> atau cukup diservis, lengkap dengan estimasi biaya.</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="text-xs px-2 py-1 rounded-lg bg-rose-500/15 text-rose-400 font-semibold border border-rose-500/30">YA — Wajib Ganti</span>
                            <span class="text-xs px-2 py-1 rounded-lg bg-emerald-500/15 text-emerald-400 font-semibold border border-emerald-500/30">TIDAK — Servis Dulu</span>
                            <span class="text-xs px-2 py-1 rounded-lg bg-amber-500/15 text-amber-400 font-semibold border border-amber-500/30">KONDISIONAL</span>
                        </div>
                    </div>

                    <!-- Kartu 3 -->
                    <div class="group bg-slate-800/80 border border-slate-700/60 hover:border-blue-500/50 rounded-3xl p-6 sm:p-7 shadow-lg hover:shadow-blue-500/10 transition-all duration-300 cursor-pointer" onclick="switchTab('katalog')">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center mb-5 group-hover:bg-blue-500/25 transition-colors">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Katalog Servis Berfilter</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Cek jadwal perawatan berkala berdasarkan jarak tempuh motormu. Dilengkapi pencarian dan filter kategori sparepart.</p>
                        <div class="mt-4 flex items-center text-blue-400 text-sm font-semibold group-hover:translate-x-1 transition-transform">
                            <span>Lihat Katalog</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- ============================================================ -->
        <!-- TAB 2: DIAGNOSA INTERAKTIF                                   -->
        <!-- ============================================================ -->
        <div id="tab-diagnosa" class="tab-content hidden opacity-0 transition-opacity duration-300">

            <!-- Header Tab -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Diagnosa Interaktif</h2>
                        <p class="text-slate-400 text-sm mt-0.5">Identifikasi kerusakan motor berdasarkan gejala yang kamu alami</p>
                    </div>
                </div>
            </div>

            <!-- Panduan Singkat -->
            <div class="bg-blue-500/10 border border-blue-500/30 rounded-2xl p-4 mb-6 flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-blue-300 mb-0.5">Cara Menggunakan</p>
                    <p class="text-xs text-slate-300 leading-relaxed">Centang semua gejala yang sesuai dengan kondisi motor kamu, lalu klik tombol <strong class="text-white">"Analisis Kerusakan Sekarang"</strong>. Kamu bisa memilih lebih dari satu gejala.</p>
                </div>
            </div>

            <!-- Form Diagnosa -->
            <form id="form-diagnosa" onsubmit="prosesDiagnosa(event)" novalidate>
                <div class="space-y-6">

                    <!-- ===== BAGIAN 1: Kelistrikan & Starter ===== -->
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-3xl overflow-hidden shadow-lg">
                        <!-- Header Kategori -->
                        <div class="px-6 py-4 border-b border-slate-700/60 bg-amber-500/5">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Kategori A</span>
                                    <h3 class="text-base font-bold text-white">Kelistrikan & Starter</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Gejala -->
                        <div class="p-5 space-y-3">
                            <!-- G01 -->
                            <label class="gejala-item flex items-start space-x-4 p-4 rounded-2xl border border-slate-700/50 hover:border-amber-500/40 hover:bg-amber-500/5 cursor-pointer transition-all duration-200 group">
                                <div class="pt-0.5 flex-shrink-0">
                                    <input type="checkbox" name="gejala" value="G01" class="gejala-checkbox w-5 h-5 rounded-md border-2 border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800 cursor-pointer">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20 flex-shrink-0">G01</span>
                                        <span class="text-xs font-semibold text-amber-400">Aki / Baterai</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-white leading-snug group-hover:text-amber-50 transition-colors">Motor starter elektrik mati / tombol starter tidak merespon sama sekali</p>
                                    <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Mesin tidak mau berputar saat tombol starter ditekan, meski terdengar bunyi "klik" atau tidak ada reaksi sama sekali.</p>
                                </div>
                            </label>

                            <!-- G02 -->
                            <label class="gejala-item flex items-start space-x-4 p-4 rounded-2xl border border-slate-700/50 hover:border-amber-500/40 hover:bg-amber-500/5 cursor-pointer transition-all duration-200 group">
                                <div class="pt-0.5 flex-shrink-0">
                                    <input type="checkbox" name="gejala" value="G02" class="gejala-checkbox w-5 h-5 rounded-md border-2 border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800 cursor-pointer">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20 flex-shrink-0">G02</span>
                                        <span class="text-xs font-semibold text-amber-400">Sistem Pengisian</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-white leading-snug group-hover:text-amber-50 transition-colors">Lampu depan redup atau klakson berbunyi kecil saat mesin langsam</p>
                                    <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Performa kelistrikan turun drastis, lampu meredup atau klakson melemah terutama saat mesin tidak digas (idle/stasioner).</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- ===== BAGIAN 2: Mesin & Performa ===== -->
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-3xl overflow-hidden shadow-lg">
                        <!-- Header Kategori -->
                        <div class="px-6 py-4 border-b border-slate-700/60 bg-rose-500/5">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-rose-500/20 border border-rose-500/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-rose-400">Kategori B</span>
                                    <h3 class="text-base font-bold text-white">Mesin & Performa</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Gejala -->
                        <div class="p-5 space-y-3">
                            <!-- G03 -->
                            <label class="gejala-item flex items-start space-x-4 p-4 rounded-2xl border border-slate-700/50 hover:border-rose-500/40 hover:bg-rose-500/5 cursor-pointer transition-all duration-200 group">
                                <div class="pt-0.5 flex-shrink-0">
                                    <input type="checkbox" name="gejala" value="G03" class="gejala-checkbox w-5 h-5 rounded-md border-2 border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800 cursor-pointer">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20 flex-shrink-0">G03</span>
                                        <span class="text-xs font-semibold text-rose-400">Filter / Injektor</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-white leading-snug group-hover:text-rose-50 transition-colors">Mesin motor ngempos, brebet, atau tarikan gas terasa berat / kosong</p>
                                    <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Saat gas ditarik, mesin tidak responsif, tersendat-sendat, atau akselerasi terasa sangat berat seperti kehabisan tenaga.</p>
                                </div>
                            </label>

                            <!-- G04 -->
                            <label class="gejala-item flex items-start space-x-4 p-4 rounded-2xl border border-slate-700/50 hover:border-rose-500/40 hover:bg-rose-500/5 cursor-pointer transition-all duration-200 group">
                                <div class="pt-0.5 flex-shrink-0">
                                    <input type="checkbox" name="gejala" value="G04" class="gejala-checkbox w-5 h-5 rounded-md border-2 border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800 cursor-pointer">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20 flex-shrink-0">G04</span>
                                        <span class="text-xs font-semibold text-rose-500">Ring Piston / Klep</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-white leading-snug group-hover:text-rose-50 transition-colors">Knalpot mengeluarkan asap putih/hitam pekat dan boros bensin</p>
                                    <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Asap tebal berwarna putih (oli terbakar) atau hitam (campuran bensin terlalu kaya) keluar dari knalpot disertai konsumsi BBM yang sangat boros.</p>
                                </div>
                            </label>

                            <!-- G05 -->
                            <label class="gejala-item flex items-start space-x-4 p-4 rounded-2xl border border-slate-700/50 hover:border-rose-500/40 hover:bg-rose-500/5 cursor-pointer transition-all duration-200 group">
                                <div class="pt-0.5 flex-shrink-0">
                                    <input type="checkbox" name="gejala" value="G05" class="gejala-checkbox w-5 h-5 rounded-md border-2 border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800 cursor-pointer">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20 flex-shrink-0">G05</span>
                                        <span class="inline-flex items-center text-xs font-bold text-red-400 bg-red-500/15 border border-red-500/30 px-2 py-0.5 rounded-full">⚠ KRITIS</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-white leading-snug group-hover:text-rose-50 transition-colors">Mesin cepat sekali panas dan terdengar suara ketukan kasar di area blok silinder</p>
                                    <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Mesin overheat dalam waktu singkat, disertai suara "tok-tok" atau "kletek-kletek" dari dalam blok mesin yang menandakan masalah serius.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- ===== BAGIAN 3: Transmisi / CVT ===== -->
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-3xl overflow-hidden shadow-lg">
                        <!-- Header Kategori -->
                        <div class="px-6 py-4 border-b border-slate-700/60 bg-emerald-500/5">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-400">Kategori C</span>
                                    <h3 class="text-base font-bold text-white">Transmisi / CVT (Matic)</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Gejala -->
                        <div class="p-5">
                            <!-- G06 -->
                            <label class="gejala-item flex items-start space-x-4 p-4 rounded-2xl border border-slate-700/50 hover:border-emerald-500/40 hover:bg-emerald-500/5 cursor-pointer transition-all duration-200 group">
                                <div class="pt-0.5 flex-shrink-0">
                                    <input type="checkbox" name="gejala" value="G06" class="gejala-checkbox w-5 h-5 rounded-md border-2 border-slate-600 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800 cursor-pointer">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20 flex-shrink-0">G06</span>
                                        <span class="text-xs font-semibold text-emerald-400">CVT / Kampas</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold text-white leading-snug group-hover:text-emerald-50 transition-colors">Terdengar suara berdecit atau getaran kasar (gredek) saat awal gas ditarik</p>
                                    <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Ada bunyi "ciiit" atau getaran kasar yang terasa di bodi saat pertama kali gas dipelintir dari posisi diam, namun menghilang saat kecepatan bertambah.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                </div><!-- /space-y-6 -->

                <!-- Alert: Belum ada yang dipilih -->
                <div id="alert-kosong" class="hidden mt-6 flex items-start space-x-3 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/40">
                    <svg class="w-5 h-5 text-rose-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="text-sm font-bold text-rose-300">Belum ada gejala yang dipilih!</p>
                        <p class="text-xs text-slate-400 mt-0.5">Silakan centang minimal satu gejala di atas sebelum melakukan analisis.</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-wrap gap-3 mt-6">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center space-x-2 px-8 py-4 bg-orange-500 hover:bg-orange-400 active:bg-orange-600 text-white font-bold text-base rounded-2xl shadow-lg shadow-orange-500/30 transition-all duration-200 hover:scale-[1.02]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <span>Analisis Kerusakan Sekarang</span>
                    </button>
                    <button type="button" onclick="resetDiagnosaForm()"
                        class="inline-flex items-center justify-center space-x-2 px-6 py-4 bg-slate-700 hover:bg-slate-600 text-slate-200 font-semibold rounded-2xl border border-slate-600/70 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Reset</span>
                    </button>
                </div>
            </form>

            <!-- ===== SECTION HASIL ANALISIS ===== -->
            <div id="section-hasil" class="hidden mt-10">
                <!-- Divider -->
                <div class="flex items-center space-x-4 mb-8">
                    <div class="flex-1 h-px bg-slate-700/70"></div>
                    <span class="text-xs font-bold uppercase tracking-widest text-slate-500 px-2">Hasil Analisis</span>
                    <div class="flex-1 h-px bg-slate-700/70"></div>
                </div>

                <!-- Ringkasan Hasil -->
                <div class="bg-slate-800/80 border border-slate-700/60 rounded-3xl p-6 sm:p-7 mb-6 shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-1">Ringkasan Diagnosa</h3>
                            <div id="badge-risk-level">
                                <!-- Diisi oleh JavaScript -->
                            </div>
                        </div>
                        <button onclick="resetDiagnosaForm()" class="inline-flex items-center space-x-2 text-sm text-slate-400 hover:text-orange-400 font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Diagnosa Ulang</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-900/60 p-4 rounded-2xl border border-slate-700/50 text-center">
                            <p class="text-3xl font-black text-orange-400" id="count-kerusakan">0</p>
                            <p class="text-xs font-medium text-slate-400 mt-1">Kemungkinan Kerusakan Terdeteksi</p>
                        </div>
                        <div class="bg-slate-900/60 p-4 rounded-2xl border border-slate-700/50 text-center">
                            <p class="text-lg sm:text-xl font-black text-orange-400 leading-tight" id="total-estimasi-biaya">-</p>
                            <p class="text-xs font-medium text-slate-400 mt-1">Total Estimasi Biaya Perbaikan</p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 mt-4 leading-relaxed">
                        ⚠ Estimasi biaya bersifat perkiraan umum. Biaya aktual dapat berbeda tergantung merek motor, bengkel, dan kondisi sparepart. Selalu bandingkan harga di beberapa bengkel.
                    </p>
                </div>

                <!-- Kartu-kartu Hasil Detail -->
                <div id="container-kartu-hasil" class="space-y-5">
                    <!-- Diisi oleh JavaScript -->
                </div>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- TAB 3: KATALOG & JADWAL PERAWATAN BERKALA                    -->
        <!-- ============================================================ -->
        <div id="tab-katalog" class="tab-content hidden opacity-0 transition-opacity duration-300">

            <!-- Header Tab -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Katalog & Jadwal Perawatan</h2>
                        <p class="text-slate-400 text-sm mt-0.5">Cek kebutuhan servis berdasarkan jarak tempuh motormu</p>
                    </div>
                </div>
            </div>

            <!-- Cek KM -->
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-3xl p-6 sm:p-7 mb-6 shadow-lg">
                <h3 class="text-base font-bold text-white mb-1">Cek Status Servis Berdasarkan KM</h3>
                <p class="text-sm text-slate-400 mb-5">Masukkan odometer motor kamu untuk mendapatkan rekomendasi servis yang tepat saat ini.</p>

                <div class="flex flex-col sm:flex-row gap-3 mb-4">
                    <div class="relative flex-1">
                        <input type="number" id="input-km" placeholder="Masukkan jarak tempuh (contoh: 12500)" min="0" max="999999"
                            class="w-full bg-slate-900/80 border border-slate-600/70 hover:border-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 text-white placeholder-slate-500 font-medium text-sm rounded-xl px-4 py-3 outline-none transition-all duration-200">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-500 font-medium pointer-events-none">KM</span>
                    </div>
                    <button onclick="cekKatalogKm()"
                        class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-orange-500 hover:bg-orange-400 text-white font-bold rounded-xl shadow-md shadow-orange-500/25 transition-all duration-200 hover:scale-105 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <span>Cek Status Servis</span>
                    </button>
                </div>

                <!-- Preset KM -->
                <div class="flex flex-wrap gap-2">
                    <span class="text-xs text-slate-500 font-medium mr-1 self-center">Contoh KM:</span>
                    <button onclick="setKmValue(2500)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-700/70 hover:bg-orange-500/20 hover:text-orange-400 hover:border-orange-500/40 text-slate-300 border border-slate-600/50 font-medium transition-all">2.500</button>
                    <button onclick="setKmValue(8000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-700/70 hover:bg-orange-500/20 hover:text-orange-400 hover:border-orange-500/40 text-slate-300 border border-slate-600/50 font-medium transition-all">8.000</button>
                    <button onclick="setKmValue(10000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-700/70 hover:bg-orange-500/20 hover:text-orange-400 hover:border-orange-500/40 text-slate-300 border border-slate-600/50 font-medium transition-all">10.000</button>
                    <button onclick="setKmValue(15000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-700/70 hover:bg-orange-500/20 hover:text-orange-400 hover:border-orange-500/40 text-slate-300 border border-slate-600/50 font-medium transition-all">15.000</button>
                    <button onclick="setKmValue(20000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-700/70 hover:bg-orange-500/20 hover:text-orange-400 hover:border-orange-500/40 text-slate-300 border border-slate-600/50 font-medium transition-all">20.000</button>
                    <button onclick="setKmValue(25000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-700/70 hover:bg-orange-500/20 hover:text-orange-400 hover:border-orange-500/40 text-slate-300 border border-slate-600/50 font-medium transition-all">25.000</button>
                </div>
            </div>

            <!-- Tabel Katalog Sparepart -->
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-3xl overflow-hidden shadow-lg">
                <!-- Header Tabel + Filter -->
                <div class="px-6 py-5 border-b border-slate-700/60">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-white mb-0.5">Daftar Sparepart & Jadwal Penggantian</h3>
                            <p class="text-xs text-slate-400">Harga estimasi untuk motor matic 110-150cc. Biaya aktual dapat berbeda.</p>
                        </div>
                        <span id="katalog-match-count" class="text-xs px-3 py-1.5 rounded-full bg-orange-500/10 text-orange-400 border border-orange-500/20 font-semibold self-start sm:self-center whitespace-nowrap">
                            5 Item Ditampilkan
                        </span>
                    </div>

                    <!-- Pencarian & Filter -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" id="search-katalog" oninput="filterKatalog()" placeholder="Cari nama sparepart, interval, estimasi..."
                                class="w-full pl-9 pr-4 py-2.5 bg-slate-900/70 border border-slate-600/70 hover:border-slate-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/30 text-white placeholder-slate-500 text-sm rounded-xl outline-none transition-all duration-200">
                        </div>
                        <select id="kategori-filter" onchange="filterKatalog()"
                            class="bg-slate-900/70 border border-slate-600/70 hover:border-slate-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/30 text-slate-200 text-sm rounded-xl px-3 py-2.5 outline-none transition-all duration-200 cursor-pointer">
                            <option value="all">Semua Kategori</option>
                            <option value="mesin">Mesin & Pelumasan</option>
                            <option value="pengapian">Pengapian & Kelistrikan</option>
                            <option value="transmisi">Transmisi / CVT</option>
                            <option value="pengereman">Pengereman</option>
                            <option value="filter">Filter & Saluran Udara</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-900/60 border-b border-slate-700/60">
                                <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Nama Sparepart</th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">Kategori</th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Interval Penggantian</th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400">Estimasi Harga</th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-katalog" class="divide-y divide-slate-700/40">

                            <!-- Oli Mesin -->
                            <tr class="katalog-row hover:bg-slate-700/20 transition-colors" data-kategori="mesin">
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-amber-500/15 border border-amber-500/25 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-sm">Oli Mesin</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Mesin & Pelumasan</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Mesin</span>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-200">2.000 – 2.500 KM</p>
                                    <p class="text-xs text-slate-500 mt-0.5">atau ±3 bulan</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-orange-400">Rp 45.000 – Rp 85.000</p>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Ganti sesuai rekomendasi pabrikan. Gunakan oli SAE yang sesuai spesifikasi motor.</p>
                                </td>
                            </tr>

                            <!-- Busi -->
                            <tr class="katalog-row hover:bg-slate-700/20 transition-colors" data-kategori="pengapian">
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-yellow-500/15 border border-yellow-500/25 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-sm">Busi Motor</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Pengapian & Kelistrikan</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Pengapian</span>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-200">8.000 – 10.000 KM</p>
                                    <p class="text-xs text-slate-500 mt-0.5">atau ±6 bulan</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-orange-400">Rp 20.000 – Rp 40.000</p>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Ganti dengan tipe dan gap yang sesuai. Busi iridium lebih tahan lama namun lebih mahal.</p>
                                </td>
                            </tr>

                            <!-- V-Belt & Roller -->
                            <tr class="katalog-row hover:bg-slate-700/20 transition-colors" data-kategori="transmisi">
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-purple-500/15 border border-purple-500/25 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-sm">V-Belt & Roller (Matic)</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Transmisi / CVT</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-400 border border-purple-500/20">Transmisi</span>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-200">20.000 – 24.000 KM</p>
                                    <p class="text-xs text-slate-500 mt-0.5">atau jika ada retakan</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-orange-400">Rp 150.000 – Rp 250.000</p>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Periksa secara visual setiap 10.000 KM. Jangan tunda jika ada retakan pada v-belt.</p>
                                </td>
                            </tr>

                            <!-- Kampas Rem -->
                            <tr class="katalog-row hover:bg-slate-700/20 transition-colors" data-kategori="pengereman">
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-rose-500/15 border border-rose-500/25 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-sm">Kampas Rem Depan/Belakang</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Pengereman</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Pengereman</span>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-200">10.000 – 15.000 KM</p>
                                    <p class="text-xs text-slate-500 mt-0.5">atau jika bunyi decit</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-orange-400">Rp 50.000 – Rp 95.000</p>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Prioritas keselamatan! Ganti segera jika ketebalan kampas sudah tipis atau ada bunyi besi bergesekan.</p>
                                </td>
                            </tr>

                            <!-- Filter Udara -->
                            <tr class="katalog-row hover:bg-slate-700/20 transition-colors" data-kategori="filter">
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-cyan-500/15 border border-cyan-500/25 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-sm">Filter Udara</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Filter & Saluran Udara</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">Filter</span>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-200">Setiap 15.000 KM</p>
                                    <p class="text-xs text-slate-500 mt-0.5">bersihkan setiap 8.000 KM</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-orange-400">Rp 40.000 – Rp 70.000</p>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Bersihkan secara berkala. Ganti jika tipe kering sudah sangat kotor atau rusak fisik.</p>
                                </td>
                            </tr>

                            <!-- Empty State -->
                            <tr id="empty-state-katalog" class="hidden">
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-700/50 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-400">Tidak ada hasil yang cocok</p>
                                        <p class="text-xs text-slate-500">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Catatan Penting -->
            <div class="mt-5 p-4 sm:p-5 rounded-2xl bg-slate-800/60 border border-slate-700/50">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-orange-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="text-sm font-bold text-white mb-1">Catatan Penting</p>
                        <p class="text-xs text-slate-400 leading-relaxed">Interval dan estimasi harga di atas adalah panduan umum untuk motor matic 110-150cc. Selalu mengacu pada buku manual motor kamu untuk rekomendasi resmi dari pabrikan. Harga sparepart dapat berbeda berdasarkan merek, jenis motor, dan lokasi bengkel.</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 mt-12 py-6 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <p class="text-xs text-slate-600 font-medium">MotoCheck &copy; 2025 — Sistem Pakar Diagnosa Kerusakan Sepeda Motor</p>
            <p class="text-xs text-slate-700 mt-1">Informasi bersifat panduan umum. Selalu konsultasikan dengan mekanik terpercaya untuk diagnosa akhir.</p>
        </div>
    </footer>

    <!-- ================================================================ -->
    <!-- MODAL: Hasil Cek KM                                              -->
    <!-- ================================================================ -->
    <div id="modal-km" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div id="modal-card" class="bg-slate-800 border border-slate-700/70 rounded-3xl w-full max-w-lg shadow-2xl transform scale-95 transition-transform duration-300">

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-700/60">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Rekomendasi Servis</h3>
                        <p class="text-xs text-slate-400" id="modal-subtitle">Analisis kebutuhan servis</p>
                    </div>
                </div>
                <button onclick="closeModalKm()" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700/50 transition-colors" aria-label="Tutup modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-5 space-y-3 max-h-[60vh] overflow-y-auto" id="modal-content-list">
                <!-- Diisi oleh JavaScript -->
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-4 border-t border-slate-700/60">
                <button onclick="closeModalKm()"
                    class="w-full py-3 bg-orange-500 hover:bg-orange-400 text-white font-bold rounded-2xl transition-colors duration-200 text-sm">
                    Tutup & Kembali
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('app.js') }}"></script>
</body>
</html>
