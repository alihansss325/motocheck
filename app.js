/**
 * ============================================================================
 * MotoCheck v3.0 - Script Logika Sistem Pakar Sisi Klien (app.js)
 * Sistem Pakar Diagnosa Kerusakan Sepeda Motor Berbasis Web
 * ============================================================================
 */

// Basis Pengetahuan Sistem Pakar (Knowledge Base)
const KNOWLEDGE_BASE = {
    'G01': {
        kode: 'G01',
        namaKerusakan: 'Aki Drop / Lemah (Battery Failure)',
        tingkat: 'Sedang',
        badgeColor: 'bg-amber-500/10 text-amber-400 border-amber-500/30',
        // --- FIELD BARU: Keputusan Penggantian Sparepart ---
        perluganti: 'KONDISIONAL',
        perlugantiReason: 'Ganti jika tegangan < 12V atau tidak bisa dicharge. Coba charge dulu sebelum memutuskan.',
        // --- FIELD URGENSI (diperbarui) ---
        urgensi: 'Sedang — Coba charge terlebih dahulu sebelum memutuskan penggantian aki.',
        urgensiBadge: 'bg-amber-500/20 text-amber-300 border-amber-500/40',
        penyebab: 'Tegangan aki di bawah standar (kurang dari 12.4 Volt), sel baterai sulfasi, atau masa pakai baterai telah habis (> 2 tahun).',
        solusi: 'Coba nyalakan mesin dengan kick starter (engkol), periksa tegangan voltase aki, bersihkan kutub terminal dari kerak putih, dan cek sistem pengisian spul/kiprok.',
        estimasi: 'Rp 150.000 - Rp 250.000',
        minBiaya: 150000,
        maxBiaya: 250000,
        iconSvg: `<svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`
    },
    'G02': {
        kode: 'G02',
        namaKerusakan: 'Sistem Pengisian / Spul / Kiprok (Charging System Defect)',
        tingkat: 'Sedang',
        badgeColor: 'bg-amber-500/10 text-amber-400 border-amber-500/30',
        // --- FIELD BARU ---
        perluganti: 'TIDAK',
        perlugantiReason: 'Prioritaskan servis & pembersihan dulu. Ganti komponen hanya jika dipastikan rusak via pengukuran multitester.',
        // --- FIELD URGENSI ---
        urgensi: 'Sedang — Servis & bersihkan terlebih dahulu, ganti komponen hanya jika terbukti rusak.',
        urgensiBadge: 'bg-blue-500/20 text-blue-300 border-blue-500/40',
        penyebab: 'Arus listrik dari spul/kiprok (regulator rectifier) tidak stabil atau drop saat langsam, soket kabel kiprok terbakar/longgar, atau kumparan spul terbakar sebagian.',
        solusi: 'Periksa tegangan output kiprok dengan multitester (normal: 13.5V - 14.8V saat digas), bersihkan soket regulator dan terminal aki, atau ganti kiprok bila tegangan overcharge/undercharge.',
        estimasi: 'Rp 50.000 - Rp 200.000',
        minBiaya: 50000,
        maxBiaya: 200000,
        iconSvg: `<svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>`
    },
    'G03': {
        kode: 'G03',
        namaKerusakan: 'Filter Udara / Injektor / Karbu Kotor (Fuel & Air Mixture Issues)',
        tingkat: 'Sedang',
        badgeColor: 'bg-amber-500/10 text-amber-400 border-amber-500/30',
        // --- FIELD BARU ---
        perluganti: 'TIDAK',
        perlugantiReason: 'Bersihkan dulu. Ganti filter hanya jika tipe kering & sudah sangat kotor atau rusak fisik.',
        // --- FIELD URGENSI ---
        urgensi: 'Sedang — Bersihkan komponen terlebih dahulu. Ganti filter jika tipe kering & kondisi sangat kotor.',
        urgensiBadge: 'bg-blue-500/20 text-blue-300 border-blue-500/40',
        penyebab: 'Suplai udara atau bahan bakar terhambat akibat debu menumpuk di elemen filter udara, lubang nosel injektor tersumbat kerak sulfur bensin, atau pilot jet/main jet karburator kotor.',
        solusi: 'Buka dan periksa box filter udara (bersihkan atau ganti baru bila tipe kering sangat kotor), lakukan servis infus injektor / semprot carb cleaner, dan gunakan bensin beroktan sesuai kompresi mesin.',
        estimasi: 'Rp 35.000 - Rp 90.000',
        minBiaya: 35000,
        maxBiaya: 90000,
        iconSvg: `<svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>`
    },
    'G04': {
        kode: 'G04',
        namaKerusakan: 'Ring Piston Aus / Sil Klep Bocor (Oil Burning & Blow-by)',
        tingkat: 'Berat',
        badgeColor: 'bg-rose-500/10 text-rose-400 border-rose-500/30',
        // --- FIELD BARU ---
        perluganti: 'YA',
        perlugantiReason: 'Wajib ganti ring piston dan/atau sil klep. Menunda akan mempercepat kerusakan blok silinder secara permanen.',
        // --- FIELD URGENSI ---
        urgensi: 'Tinggi — Segera jadwalkan overhaul. Menunda mempercepat kerusakan blok silinder permanen.',
        urgensiBadge: 'bg-rose-500/20 text-rose-300 border-rose-500/40',
        penyebab: 'Oli mesin naik dan ikut terbakar ke ruang kompresi karena celah ring piston aus atau karet sil klep mengeras/retak, memicu penurunan kompresi dan konsumsi oli sangat boros.',
        solusi: 'Cek dipstick oli secara rutin agar volume oli tidak habis total. Segera jadwalkan pembongkaran blok silinder (bore up / korter / ganti ring piston & sil klep orisinil).',
        estimasi: 'Rp 200.000 - Rp 600.000+',
        minBiaya: 200000,
        maxBiaya: 600000,
        iconSvg: `<svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
    },
    'G05': {
        kode: 'G05',
        namaKerusakan: 'Kekurangan Oli / Piston & Stang Seher Oblak (Severe Engine Wear)',
        tingkat: 'Berat',
        badgeColor: 'bg-rose-500/10 text-rose-400 border-rose-500/30',
        // --- FIELD BARU ---
        perluganti: 'YA',
        perlugantiReason: 'Wajib overhaul total — ganti piston, stang seher, dan kemungkinan kruk as. MATIKAN MESIN SEKARANG.',
        // --- FIELD URGENSI ---
        urgensi: 'DARURAT — Matikan mesin sekarang! Overheat ekstrem dapat menyebabkan mesin macet total (jebol).',
        urgensiBadge: 'bg-rose-600/30 text-rose-200 border-rose-500/60 font-bold',
        penyebab: 'Volume oli mesin menyusut drastis atau habis total, terjadi friksi logam ekstrem tanpa pelumas, memicu clearance kruk as/stang seher (connecting rod) oblak dan piston membentur dinding silinder.',
        solusi: 'Matikan mesin secepatnya dan jangan dipaksa hidup! Periksa dipstick / kaca intip oli. Tambahkan oli darurat atau derek motor ke bengkel terpercaya untuk cek kerusakan stang piston & kruk as.',
        estimasi: 'Rp 150.000 - Rp 800.000+',
        minBiaya: 150000,
        maxBiaya: 800000,
        iconSvg: `<svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>`
    },
    'G06': {
        kode: 'G06',
        namaKerusakan: 'Kampas Ganda / Rumah CVT Kotor (Clutch Bell Glazing & Dust)',
        tingkat: 'Ringan',
        badgeColor: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
        // --- FIELD BARU ---
        perluganti: 'TIDAK',
        perlugantiReason: 'Bersihkan CVT & grease terlebih dahulu. Ganti kampas ganda hanya jika ketebalan sudah di bawah batas minimal.',
        // --- FIELD URGENSI ---
        urgensi: 'Ringan — Servis & bersihkan CVT dulu. Ganti kampas ganda hanya jika sudah tipis.',
        urgensiBadge: 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
        penyebab: 'Penumpukan debu residu gesekan kampas ganda di dalam mangkok kopling CVT, permukaan mangkok licin (glazing), atau grease (gemuk) CVT mengering.',
        solusi: 'Lakukan servis CVT berkala: bongkar rumah kopling, bersihkan debu dengan angin kompresor, amplas halus tapak kampas ganda, cuci mangkok CVT, dan lumasi bearing dengan grease CVT high-temp.',
        estimasi: 'Rp 30.000 - Rp 60.000',
        minBiaya: 30000,
        maxBiaya: 60000,
        iconSvg: `<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
    }
};

/**
 * 1. Fungsi switchTab(tabName)
 * Berfungsi untuk navigasi antar tab/halaman tanpa reload.
 */
function switchTab(tabName) {
    // Sembunyikan semua tab content
    const allTabs = document.querySelectorAll('.tab-content');
    allTabs.forEach(tab => {
        tab.classList.add('hidden');
        tab.classList.remove('opacity-100');
        tab.classList.add('opacity-0');
    });

    // Tampilkan tab yang dipilih
    const activeTab = document.getElementById(`tab-${tabName}`);
    if (activeTab) {
        activeTab.classList.remove('hidden');
        setTimeout(() => {
            activeTab.classList.remove('opacity-0');
            activeTab.classList.add('opacity-100');
        }, 10);
    }

    // Update style navigasi desktop
    const navButtons = [
        { id: 'nav-btn-home', key: 'home' },
        { id: 'nav-btn-diagnosa', key: 'diagnosa' },
        { id: 'nav-btn-katalog', key: 'katalog' }
    ];

    navButtons.forEach(btnInfo => {
        const btn = document.getElementById(btnInfo.id);
        if (btn) {
            if (btnInfo.key === tabName) {
                btn.className = "tab-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-2 bg-orange-500 text-white shadow-md shadow-orange-500/25";
            } else {
                btn.className = "tab-btn px-5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 flex items-center space-x-2 text-slate-300 hover:text-white hover:bg-slate-700/50";
            }
        }
    });

    // Update mobile menu jika ada
    const mobileNavButtons = [
        { id: 'mobile-nav-home', key: 'home' },
        { id: 'mobile-nav-diagnosa', key: 'diagnosa' },
        { id: 'mobile-nav-katalog', key: 'katalog' }
    ];
    mobileNavButtons.forEach(btnInfo => {
        const btn = document.getElementById(btnInfo.id);
        if (btn) {
            if (btnInfo.key === tabName) {
                btn.className = "w-full text-left px-4 py-3 rounded-xl font-semibold text-sm bg-orange-500 text-white";
            } else {
                btn.className = "w-full text-left px-4 py-3 rounded-xl font-medium text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors";
            }
        }
    });

    // Tutup mobile menu jika terbuka
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
    }

    // Scroll halus ke atas
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/**
 * Helper untuk Mobile Menu Toggle
 */
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

/**
 * Helper untuk mendapatkan konfigurasi badge "Perlu Ganti Sparepart"
 */
function getPerlugantiBadgeConfig(perluganti) {
    switch (perluganti) {
        case 'YA':
            return {
                containerClass: 'bg-rose-500/15 border-rose-500/50',
                badgeClass: 'bg-rose-500 text-white',
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>`,
                label: 'YA — WAJIB GANTI',
                labelColor: 'text-rose-300'
            };
        case 'TIDAK':
            return {
                containerClass: 'bg-emerald-500/15 border-emerald-500/50',
                badgeClass: 'bg-emerald-500 text-white',
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`,
                label: 'TIDAK — BISA DISERVIS',
                labelColor: 'text-emerald-300'
            };
        case 'KONDISIONAL':
        default:
            return {
                containerClass: 'bg-amber-500/15 border-amber-500/50',
                badgeClass: 'bg-amber-500 text-white',
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
                label: 'KONDISIONAL — CEK DULU',
                labelColor: 'text-amber-300'
            };
    }
}

/**
 * 2. Fungsi prosesDiagnosa(event)
 * Memproses aturan sistem pakar (rule engine sederhana) untuk gejala G01 s.d G06.
 */
function prosesDiagnosa(event) {
    if (event) {
        event.preventDefault();
    }

    const checkedBoxes = document.querySelectorAll('input[name="gejala"]:checked');
    const alertKosong = document.getElementById('alert-kosong');
    const sectionHasil = document.getElementById('section-hasil');
    const containerHasil = document.getElementById('container-kartu-hasil');
    const countKerusakanEl = document.getElementById('count-kerusakan');
    const totalEstimasiEl = document.getElementById('total-estimasi-biaya');
    const badgeRiskLevel = document.getElementById('badge-risk-level');

    // Jika belum ada gejala yang dipilih
    if (checkedBoxes.length === 0) {
        alertKosong.classList.remove('hidden');
        sectionHasil.classList.add('hidden');
        alertKosong.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // Sembunyikan alert kosong
    alertKosong.classList.add('hidden');

    let hasilList = [];
    let totalMin = 0;
    let totalMax = 0;
    let hasBerat = false;
    let hasSedang = false;

    checkedBoxes.forEach(cb => {
        const kode = cb.value;
        if (KNOWLEDGE_BASE[kode]) {
            const data = KNOWLEDGE_BASE[kode];
            hasilList.push(data);
            totalMin += data.minBiaya;
            totalMax += data.maxBiaya;

            if (data.tingkat === 'Berat') hasBerat = true;
            if (data.tingkat === 'Sedang') hasSedang = true;
        }
    });

    // Hitung status risiko tertinggi keseluruhan
    if (badgeRiskLevel) {
        if (hasBerat) {
            badgeRiskLevel.innerHTML = `
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/40">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Status Risiko: KRITIS — Wajib Penanganan Segera</span>
                </span>`;
        } else if (hasSedang) {
            badgeRiskLevel.innerHTML = `
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Status Risiko: SEDANG — Perlu Perbaikan</span>
                </span>`;
        } else {
            badgeRiskLevel.innerHTML = `
                <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Status Risiko: RINGAN — Pemeliharaan Standar</span>
                </span>`;
        }
    }

    // Format Rupiah
    const formatRupiah = (val) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
    totalEstimasiEl.textContent = `${formatRupiah(totalMin)} - ${formatRupiah(totalMax)}`;
    countKerusakanEl.textContent = hasilList.length;

    // Render Kartu Hasil Dinamis
    containerHasil.innerHTML = '';

    hasilList.forEach((item) => {
        const badge = getPerlugantiBadgeConfig(item.perluganti);
        const card = document.createElement('div');
        card.className = "bg-slate-800/90 border border-slate-700/80 hover:border-orange-500/40 rounded-3xl p-6 sm:p-8 shadow-xl transition-all duration-300 animate-fade-in";

        card.innerHTML = `
            <!-- Header: Kode, Tingkat, Nama Kerusakan, Estimasi -->
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-5 border-b border-slate-700/70">
                <div class="flex items-start space-x-4">
                    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-700/80 flex-shrink-0 shadow-inner mt-0.5">
                        ${item.iconSvg}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded text-xs font-mono font-bold bg-orange-500/10 text-orange-400 border border-orange-500/20">${item.kode}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border ${item.badgeColor}">
                                Tingkat Bahaya: ${item.tingkat}
                            </span>
                        </div>
                        <h4 class="text-lg sm:text-xl font-bold text-white tracking-tight leading-snug">${item.namaKerusakan}</h4>
                    </div>
                </div>

                <div class="sm:text-right bg-slate-900/60 p-3 sm:p-3.5 rounded-2xl border border-slate-700/40 flex-shrink-0">
                    <span class="text-xs text-slate-400 block font-medium mb-0.5">Estimasi Biaya Suku Cadang:</span>
                    <span class="text-base sm:text-lg font-extrabold text-orange-400">${item.estimasi}</span>
                </div>
            </div>

            <!-- SECTION UTAMA: Keputusan Penggantian Sparepart -->
            <div class="mt-5 p-4 sm:p-5 rounded-2xl border-2 ${badge.containerClass} flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                <!-- Badge YA / TIDAK / KONDISIONAL -->
                <div class="flex-shrink-0">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl ${badge.badgeClass} font-bold text-sm shadow-lg">
                        ${badge.icon}
                        <span>${badge.label}</span>
                    </div>
                </div>
                <!-- Keterangan -->
                <div class="flex-1">
                    <p class="text-xs font-bold uppercase tracking-wider ${badge.labelColor} mb-0.5">Keputusan Penggantian Sparepart</p>
                    <p class="text-sm text-slate-200 leading-relaxed font-medium">${item.perlugantiReason}</p>
                </div>
            </div>

            <!-- Urgensi Penanganan -->
            <div class="mt-3 px-4 py-3 rounded-xl bg-slate-900/60 border border-slate-700/50 flex items-center space-x-2.5">
                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tingkat Urgensi Penanganan: </span>
                    <span class="text-xs sm:text-sm font-semibold text-slate-200">${item.urgensi}</span>
                </div>
            </div>

            <!-- Rincian Penyebab & Solusi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="bg-slate-900/60 p-4 rounded-2xl border border-slate-700/50">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center space-x-1.5 mb-2.5">
                        <svg class="w-4 h-4 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Akar Masalah / Penyebab Utama</span>
                    </span>
                    <p class="text-sm text-slate-300 leading-relaxed">${item.penyebab}</p>
                </div>

                <div class="bg-slate-900/60 p-4 rounded-2xl border border-slate-700/50">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-500 flex items-center space-x-1.5 mb-2.5">
                        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Solusi & Pertolongan Pertama</span>
                    </span>
                    <p class="text-sm text-slate-300 leading-relaxed">${item.solusi}</p>
                </div>
            </div>
        `;

        containerHasil.appendChild(card);
    });

    // Tampilkan section hasil & scroll
    sectionHasil.classList.remove('hidden');
    const saveStatus = document.getElementById('save-diagnosis-status');
    if (saveStatus) {
        saveStatus.textContent = 'Menyimpan riwayat diagnosa...';
        fetch('/api/diagnoses', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ symptoms: Array.from(checkedBoxes, (checkbox) => checkbox.value) }),
        }).then((response) => {
            if (!response.ok) {
                throw new Error(`Diagnosa tidak dapat disimpan (HTTP ${response.status}).`);
            }
            saveStatus.textContent = 'Riwayat diagnosa berhasil disimpan.';
        }).catch((error) => {
            saveStatus.textContent = `${error.message} Hasil diagnosa tetap tersedia pada halaman ini.`;
        });
    }
    sectionHasil.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/**
 * Reset Formulir Diagnosa
 */
function resetDiagnosaForm() {
    const form = document.getElementById('form-diagnosa');
    if (form) form.reset();
    document.getElementById('alert-kosong').classList.add('hidden');
    document.getElementById('section-hasil').classList.add('hidden');
    // Scroll kembali ke atas form
    const formSection = document.getElementById('form-diagnosa');
    if (formSection) formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/**
 * Quick Helper untuk memilih preset jarak tempuh KM
 */
function setKmValue(val) {
    const inputKm = document.getElementById('input-km');
    if (inputKm) {
        inputKm.value = val;
        cekKatalogKm();
    }
}

/**
 * 3. Fungsi cekKatalogKm()
 * Mengecek input KM dan memunculkan modal popup kustom berisi saran servis yang relevan.
 */
function cekKatalogKm() {
    const inputKm = document.getElementById('input-km');
    const km = parseInt(inputKm.value, 10);

    if (isNaN(km) || km < 0) {
        alert('Silakan masukkan angka jarak tempuh (KM) motor yang valid!');
        if (inputKm) inputKm.focus();
        return;
    }

    const modal = document.getElementById('modal-km');
    const modalCard = document.getElementById('modal-card');
    const modalSubtitle = document.getElementById('modal-subtitle');
    const modalList = document.getElementById('modal-content-list');

    modalSubtitle.textContent = `Analisis Kebutuhan Servis pada Odometer: ${km.toLocaleString('id-ID')} KM`;
    modalList.innerHTML = '';

    const aturanServis = [
        {
            nama: 'Oli Mesin',
            interval: 'Setiap 2.000 - 2.500 KM',
            harga: 'Rp 45.000 - Rp 85.000',
            isDue: (km % 2500 <= 500) || (km >= 2000 && km <= 3000) || (km % 2000 === 0),
            status: (km % 2500 <= 500) ? 'Sangat Dianjurkan Ganti Baru' : 'Periksa Ketinggian & Kejernihan Oli Mesin',
            level: (km % 2500 <= 500) ? 'Wajib' : 'Pemeriksaan Rutin'
        },
        {
            nama: 'Busi Motor',
            interval: 'Setiap 8.000 - 10.000 KM',
            harga: 'Rp 20.000 - Rp 40.000',
            isDue: (km >= 8000 && (km % 8000 <= 1500 || km % 10000 <= 1500)),
            status: (km >= 8000 && (km % 8000 <= 1500 || km % 10000 <= 1500)) ? 'Jatuh Tempo Penggantian Busi' : 'Kondisi Relatif Aman (Cek jika tarikan brebet)',
            level: (km >= 8000 && (km % 8000 <= 1500 || km % 10000 <= 1500)) ? 'Wajib' : 'Kondisi Normal'
        },
        {
            nama: 'Kampas Rem Depan / Belakang',
            interval: 'Setiap 10.000 - 15.000 KM',
            harga: 'Rp 50.000 - Rp 95.000',
            isDue: (km >= 10000 && (km % 10000 <= 2000 || km % 15000 <= 2000)),
            status: (km >= 10000 && (km % 10000 <= 2000 || km % 15000 <= 2000)) ? 'Cek Ketebalan Kampas / Ganti Baru' : 'Pantau Jarak Bebas Tuas Rem',
            level: (km >= 10000 && (km % 10000 <= 2000 || km % 15000 <= 2000)) ? 'Penting' : 'Kondisi Normal'
        },
        {
            nama: 'Filter Udara',
            interval: 'Setiap 15.000 KM',
            harga: 'Rp 40.000 - Rp 70.000',
            isDue: (km >= 15000 && (km % 15000 <= 2000)),
            status: (km >= 15000 && (km % 15000 <= 2000)) ? 'Wajib Ganti Elemen Filter Baru' : 'Bersihkan Box Filter Dari Debu Kotoran',
            level: (km >= 15000 && (km % 15000 <= 2000)) ? 'Wajib' : 'Kondisi Normal'
        },
        {
            nama: 'V-Belt & Roller (Matic)',
            interval: 'Setiap 20.000 - 24.000 KM',
            harga: 'Rp 150.000 - Rp 250.000',
            isDue: (km >= 20000 && (km % 20000 <= 3000 || km % 24000 <= 3000)),
            status: (km >= 20000 && (km % 20000 <= 3000 || km % 24000 <= 3000)) ? 'Periksa Retakan Sabuk & Keausan Roller' : 'Bersihkan Ruang CVT dari Debu Residu',
            level: (km >= 20000 && (km % 20000 <= 3000 || km % 24000 <= 3000)) ? 'Sangat Penting' : 'Kondisi Normal'
        }
    ];

    aturanServis.forEach(item => {
        const row = document.createElement('div');
        const isUrgent = item.isDue;

        row.className = `p-4 rounded-2xl border transition-all ${
            isUrgent
            ? 'bg-orange-500/10 border-orange-500/40 shadow-sm'
            : 'bg-slate-900/60 border-slate-700/50'
        }`;

        row.innerHTML = `
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <h4 class="font-bold text-sm text-white">${item.nama}</h4>
                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold ${
                            isUrgent
                            ? 'bg-orange-500 text-white'
                            : 'bg-slate-700 text-slate-300'
                        }">${item.level}</span>
                    </div>
                    <p class="text-xs text-slate-200 font-medium">${item.status}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Interval Standar: ${item.interval}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="text-xs text-slate-400 block font-medium">Estimasi:</span>
                    <span class="text-xs sm:text-sm font-bold text-orange-400">${item.harga}</span>
                </div>
            </div>
        `;
        modalList.appendChild(row);
    });

    // Tampilkan Modal
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modalCard.classList.remove('scale-95');
        modalCard.classList.add('scale-100');
    }, 10);
}

/**
 * Tutup Modal KM
 */
function closeModalKm() {
    const modal = document.getElementById('modal-km');
    const modalCard = document.getElementById('modal-card');
    if (!modal) return;

    if (modalCard) {
        modalCard.classList.remove('scale-100');
        modalCard.classList.add('scale-95');
    }
    modal.classList.add('opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 250);
}

/**
 * 4. Fungsi filterKatalog()
 * Menyaring baris tabel sparepart secara real-time berdasarkan kata kunci pencarian
 * dan kategori yang dipilih dari dropdown.
 */
function filterKatalog() {
    const searchInput = document.getElementById('search-katalog');
    const categorySelect = document.getElementById('kategori-filter');
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const selectedCategory = categorySelect ? categorySelect.value : 'all';

    const rows = document.querySelectorAll('#table-body-katalog tr.katalog-row');
    const emptyState = document.getElementById('empty-state-katalog');
    const countBadge = document.getElementById('katalog-match-count');

    let visibleCount = 0;

    rows.forEach(row => {
        const rowCategory = row.getAttribute('data-kategori') || '';
        const rowText = row.innerText.toLowerCase();

        // Cek kategori
        const categoryMatches = (selectedCategory === 'all') || (rowCategory === selectedCategory);
        // Cek teks pencarian
        const queryMatches = (query === '') || (rowText.includes(query));

        if (categoryMatches && queryMatches) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });

    // Update counter badge
    if (countBadge) {
        countBadge.textContent = `${visibleCount} Item Ditampilkan`;
    }

    // Tampilkan pesan kosong jika tidak ada hasil
    if (emptyState) {
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
}

// Event Listeners untuk Tutup Modal
window.addEventListener('click', function(e) {
    const modal = document.getElementById('modal-km');
    if (e.target === modal) {
        closeModalKm();
    }
});

window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModalKm();
    }
});

window.addEventListener('DOMContentLoaded', function() {
    const tabName = window.location.hash.replace('#tab-', '');
    if (['home', 'diagnosa', 'katalog'].includes(tabName)) {
        switchTab(tabName);
    }
});
