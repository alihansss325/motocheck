const dashboardData = window.dashboardData;
const diagnoses = dashboardData.diagnoses.map((item, index) => ({
    ...item,
    color: ['blue', 'purple', 'green', 'orange', 'teal', 'rose', 'amber'][index % 7],
}));

const knowledgeItems = [
    { code: 'G01', name: 'Aki drop / lemah', severity: 'Sedang', detail: 'Tegangan aki di bawah standar, sel baterai melemah, atau masa pakai baterai telah habis.' },
    { code: 'G02', name: 'Sistem pengisian / spul / kiprok', severity: 'Sedang', detail: 'Arus listrik dari spul atau kiprok tidak stabil, soket kabel longgar, atau kumparan spul bermasalah.' },
    { code: 'G03', name: 'Filter udara / injektor / karburator kotor', severity: 'Sedang', detail: 'Suplai udara atau bahan bakar terhambat karena penumpukan debu atau kerak.' },
    { code: 'G04', name: 'Ring piston aus / sil klep bocor', severity: 'Berat', detail: 'Oli masuk ke ruang kompresi, menyebabkan kompresi turun dan konsumsi oli meningkat.' },
    { code: 'G05', name: 'Kekurangan oli / piston & stang seher oblak', severity: 'Berat', detail: 'Pelumasan tidak memadai menyebabkan gesekan logam berlebih dan berisiko merusak mesin.' },
    { code: 'G06', name: 'Kampas ganda / rumah CVT kotor', severity: 'Ringan', detail: 'Debu atau glazing pada komponen CVT dapat menimbulkan getaran saat motor mulai berjalan.' },
];

const severityClass = { Ringan: 'light', Sedang: 'medium', Berat: 'heavy' };
const avatarColors = { blue: '#eaf2ff;color:#5482c7', purple: '#f1ebff;color:#8062ba', green: '#e9f6ef;color:#438e68', orange: '#fff0e5;color:#d77937', teal: '#e8f6f5;color:#438e88', rose: '#fff0f2;color:#ca6473', amber: '#fff5df;color:#bc8730' };
let visibleCount = 5;
let toastTimer;

function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
    })[character]);
}

function renderRows(targetId, rows) {
    const target = document.getElementById(targetId);
    if (!target) return;
    if (rows.length === 0) {
        target.innerHTML = '<tr><td colspan="5">Tidak ada riwayat diagnosa yang cocok.</td></tr>';
        return;
    }
    target.innerHTML = rows.map((item) => `
        <tr>
            <td><div class="user-cell"><span class="avatar" style="background:${avatarColors[item.color].split(';')[0]};${avatarColors[item.color].split(';')[1]}">${escapeHtml(item.initials)}</span><span class="user-copy"><strong>${escapeHtml(item.name)}</strong><small>${escapeHtml(item.email)}</small></span></div></td>
            <td><span class="diagnosis-name">${escapeHtml(item.diagnosis)}</span><span class="diagnosis-code">${escapeHtml(item.code)}</span></td>
            <td><span class="severity ${severityClass[item.severity]}">${escapeHtml(item.severity)}</span></td>
            <td>${escapeHtml(item.time)}</td>
            <td><span class="status ${item.status === 'Selesai' ? 'complete' : 'review'}">${escapeHtml(item.status)}</span></td>
        </tr>`).join('');
}

function filterDiagnoses(query, severity) {
    const normalizedQuery = query.trim().toLocaleLowerCase('id');
    return diagnoses.filter((item) => {
        const matchesText = !normalizedQuery || `${item.name} ${item.email} ${item.diagnosis} ${item.code}`.toLocaleLowerCase('id').includes(normalizedQuery);
        return matchesText && (severity === 'all' || item.severity === severity);
    });
}

function updateOverviewTable() {
    const matches = filterDiagnoses(document.getElementById('table-search').value, document.getElementById('severity-filter').value);
    renderRows('diagnosis-table', matches.slice(0, visibleCount));
    document.getElementById('results-count').textContent = `Menampilkan ${Math.min(visibleCount, matches.length)} dari ${matches.length} diagnosa terbaru`;
    document.getElementById('show-more').hidden = matches.length <= visibleCount;
}

function updateAllTable() {
    const matches = filterDiagnoses(document.getElementById('diagnostics-search').value, document.getElementById('diagnostics-filter').value);
    renderRows('all-diagnosis-table', matches);
    document.getElementById('all-results-count').textContent = `${matches.length} dari ${Math.min(dashboardData.recentCount, dashboardData.totalDiagnoses)} diagnosa terbaru`;
}

function renderTopDiagnoses() {
    const target = document.getElementById('top-diagnoses');
    const diagnoses = dashboardData.topDiagnoses;
    target.innerHTML = diagnoses.length
        ? diagnoses.map((item, index) => `
            <div class="issue-row">
                <span class="issue-rank">${String(index + 1).padStart(2, '0')}</span>
                <span class="issue-copy"><strong>${escapeHtml(item.name)}</strong><small>${item.count} temuan pada riwayat terbaru</small></span>
                <span class="issue-value">${item.percentage}%</span>
                <div class="issue-meter"><i style="width:${Math.min(item.percentage, 100)}%"></i></div>
            </div>`).join('')
        : '<p class="empty-diagnoses">Belum ada data diagnosa.</p>';
}

function renderActivityChart(days) {
    const activity = days === 30 ? dashboardData.chart : dashboardData.chart.slice(-7);
    const max = Math.max(...activity.map((item) => item.count), 1);
    document.querySelectorAll('.chart-y-labels span').forEach((label, index) => {
        label.textContent = Math.round(max * (1 - index / 4)).toLocaleString('id-ID');
    });
    const points = activity.map((item, index) => ({
        x: activity.length > 1 ? (index / (activity.length - 1)) * 700 : 350,
        y: 190 - (item.count / max) * 165,
    }));
    const linePath = points.map((point, index) => `${index ? 'L' : 'M'}${point.x.toFixed(1)} ${point.y.toFixed(1)}`).join(' ');
    document.querySelector('.chart-line').setAttribute('d', linePath);
    document.querySelector('.chart-fill').setAttribute('d', `${linePath} L700 220 L0 220 Z`);
    document.getElementById('chart-labels').innerHTML = activity.map((item) => `<span>${escapeHtml(item.label)}</span>`).join('');
    document.getElementById('chart-total').textContent = activity.reduce((sum, item) => sum + item.count, 0).toLocaleString('id-ID');
}

function setView(viewName) {
    const panel = document.getElementById(`view-${viewName}`);
    if (!panel) return;
    document.querySelectorAll('.view-panel').forEach((item) => item.classList.toggle('active', item === panel));
    document.querySelectorAll('.nav-link').forEach((item) => item.classList.toggle('active', item.dataset.view === viewName));
    document.getElementById('breadcrumb-current').textContent = {
        overview: 'Ringkasan', diagnostics: 'Riwayat Diagnosa',
        knowledge: 'Basis Pengetahuan', catalog: 'Katalog Servis',
    }[viewName];
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('menu-toggle').setAttribute('aria-expanded', 'false');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('visible');
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(() => toast.classList.remove('visible'), 3200);
}

function exportDiagnoses() {
    const isDiagnosticsView = document.getElementById('view-diagnostics').classList.contains('active');
    const rows = filterDiagnoses(
        document.getElementById(isDiagnosticsView ? 'diagnostics-search' : 'table-search').value,
        document.getElementById(isDiagnosticsView ? 'diagnostics-filter' : 'severity-filter').value,
    );
    const columns = ['Nama pengguna', 'Email', 'Diagnosa', 'Kode', 'Tingkat', 'Waktu', 'Status'];
    const csvRows = [columns, ...rows.map((row) => [row.name, row.email, row.diagnosis, row.code, row.severity, row.time, row.status])];
    const csv = `\uFEFF${csvRows.map((row) => row.map((cell) => `"${String(cell).replaceAll('"', '""')}"`).join(',')).join('\r\n')}`;
    const downloadUrl = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = 'motocheck-riwayat-diagnosa.csv';
    document.body.appendChild(link);
    link.click();
    link.remove();
    window.setTimeout(() => URL.revokeObjectURL(downloadUrl), 1000);
    showToast('Laporan diagnosa terbaru berhasil diekspor sebagai CSV.');
}

function renderKnowledge() {
    const target = document.getElementById('knowledge-grid');
    target.innerHTML = knowledgeItems.map((item) => `
        <article class="knowledge-card">
            <div class="knowledge-top"><span class="knowledge-code">${item.code}</span><span class="severity ${severityClass[item.severity]}">${item.severity}</span></div>
            <h3>${escapeHtml(item.name)}</h3><p>${escapeHtml(item.detail)}</p>
        </article>`).join('');
}

function initDashboard() {
    renderRows('diagnosis-table', diagnoses.slice(0, visibleCount));
    renderRows('all-diagnosis-table', diagnoses);
    renderKnowledge();
    renderTopDiagnoses();
    document.querySelectorAll('[data-stat="total"]').forEach((item) => { item.textContent = dashboardData.totalDiagnoses.toLocaleString('id-ID'); });
    document.querySelectorAll('[data-stat="users"]').forEach((item) => { item.textContent = dashboardData.registeredUsers.toLocaleString('id-ID'); });
    document.querySelectorAll('[data-stat="today"]').forEach((item) => { item.textContent = dashboardData.todayDiagnoses.toLocaleString('id-ID'); });
    document.querySelectorAll('[data-stat="knowledge"]').forEach((item) => { item.textContent = dashboardData.knowledgeItems.toLocaleString('id-ID'); });
    document.querySelector('.nav-count').textContent = dashboardData.totalDiagnoses.toLocaleString('id-ID');
    renderActivityChart(7);
    const now = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit' }).format(new Date());
    document.getElementById('updated-time').textContent = `hari ini, ${now}`;

    document.querySelectorAll('.nav-link').forEach((button) => button.addEventListener('click', () => setView(button.dataset.view)));
    document.querySelectorAll('[data-go]').forEach((button) => button.addEventListener('click', () => setView(button.dataset.go)));
    document.getElementById('table-search').addEventListener('input', updateOverviewTable);
    document.getElementById('severity-filter').addEventListener('change', updateOverviewTable);
    document.getElementById('diagnostics-search').addEventListener('input', updateAllTable);
    document.getElementById('diagnostics-filter').addEventListener('change', updateAllTable);
    document.getElementById('show-more').addEventListener('click', () => {
        visibleCount = diagnoses.length;
        updateOverviewTable();
    });
    document.getElementById('export-button').addEventListener('click', exportDiagnoses);
    document.getElementById('export-button-secondary').addEventListener('click', exportDiagnoses);
    document.getElementById('global-search').addEventListener('input', (event) => {
        setView('diagnostics');
        document.getElementById('diagnostics-search').value = event.target.value;
        updateAllTable();
    });
    document.getElementById('period-select').addEventListener('change', (event) => {
        renderActivityChart(Number(event.target.value));
    });
    document.getElementById('menu-toggle').addEventListener('click', (event) => {
        const sidebar = document.getElementById('sidebar');
        const isOpen = sidebar.classList.toggle('open');
        event.currentTarget.setAttribute('aria-expanded', String(isOpen));
    });
    document.getElementById('notice-dismiss').addEventListener('click', () => document.querySelector('.preview-notice').remove());
    document.getElementById('notification-button').addEventListener('click', () => showToast('Tidak ada notifikasi baru.'));
    document.addEventListener('keydown', (event) => {
        if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
            event.preventDefault();
            document.getElementById('global-search').focus();
        }
        if (event.key === 'Escape') {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('menu-toggle').setAttribute('aria-expanded', 'false');
        }
    });
}

document.addEventListener('DOMContentLoaded', initDashboard);
