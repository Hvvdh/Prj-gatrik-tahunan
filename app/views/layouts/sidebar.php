<?php
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
function isActive($path, $currentUri): string {
    return strpos($currentUri, $path) !== false ? 'active' : '';
}
?>
<aside class="sidebar-wrapper">
    <ul class="sidebar-menu">
        
        <!-- DASHBOARD UTAMA -->
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/dashboard" class="sidebar-link <?= isActive('/dashboard', $currentUri) && !isActive('/dashboard/executive', $currentUri) ? 'active' : '' ?>">
                <div class="nav-icon-badge icon-blue"><i class="fas fa-chart-line"></i></div>
                <span>Dashboard Utama</span>
            </a>
        </li>

        <!-- DATA UTAMA SECTION -->
        <li class="sidebar-heading">Data Utama</li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/licenses" class="sidebar-link <?= isActive('/licenses', $currentUri) ?>">
                <div class="nav-icon-badge icon-blue"><i class="fas fa-id-card"></i></div>
                <span>Data Izin Usaha Ketenagalistrikan</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/technical-personnel" class="sidebar-link <?= isActive('/technical-personnel', $currentUri) ?>">
                <div class="nav-icon-badge icon-purple"><i class="fas fa-users-cog"></i></div>
                <span>Data Tenaga Teknik</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/slo" class="sidebar-link <?= isActive('/slo', $currentUri) ?>">
                <div class="nav-icon-badge icon-red"><i class="fas fa-shield-alt"></i></div>
                <span>Data SLO</span>
            </a>
        </li>

        <!-- PELAPORAN SECTION -->
        <li class="sidebar-heading">Pelaporan</li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/reports/iuptls" class="sidebar-link <?= isActive('/reports/iuptls', $currentUri) ?>">
                <div class="nav-icon-badge icon-blue"><i class="fas fa-file-invoice"></i></div>
                <span>Laporan IUPTLS</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/reports/stl" class="sidebar-link <?= isActive('/reports/stl', $currentUri) ?>">
                <div class="nav-icon-badge icon-orange"><i class="fas fa-file-contract"></i></div>
                <span>Laporan STL</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/reports/production" class="sidebar-link <?= isActive('/reports/production', $currentUri) ?>">
                <div class="nav-icon-badge icon-emerald"><i class="fas fa-bolt"></i></div>
                <span>Produksi Listrik</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/reports/iujptl" class="sidebar-link <?= isActive('/reports/iujptl', $currentUri) ?>">
                <div class="nav-icon-badge icon-violet"><i class="fas fa-briefcase"></i></div>
                <span>Laporan IUJPTL</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/reports/templates" class="sidebar-link <?= isActive('/reports/templates', $currentUri) ?>">
                <div class="nav-icon-badge icon-pink"><i class="fas fa-file-download"></i></div>
                <span>Format Pelaporan</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/reports/history" class="sidebar-link <?= isActive('/reports/history', $currentUri) ?>">
                <div class="nav-icon-badge icon-slate"><i class="fas fa-history"></i></div>
                <span>History Laporan</span>
            </a>
        </li>

        <!-- LAINNYA SECTION -->
        <li class="sidebar-heading">Lainnya</li>
        <?php if (AuthHelper::hasRole(['SUPER_ADMIN', 'ADMIN_INSTANSI'])): ?>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/users" class="sidebar-link <?= isActive('/users', $currentUri) ?>">
                <div class="nav-icon-badge icon-amber"><i class="fas fa-user-shield"></i></div>
                <span>Manajemen Akun</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/approval" class="sidebar-link <?= isActive('/approval', $currentUri) ?>">
                <div class="nav-icon-badge icon-orange"><i class="fas fa-check-double"></i></div>
                <span>Persetujuan Laporan</span>
            </a>
        </li>
        <?php endif; ?>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/contact" class="sidebar-link <?= isActive('/contact', $currentUri) ?>">
                <div class="nav-icon-badge icon-teal"><i class="fas fa-envelope"></i></div>
                <span>Kontak Kami</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= BASE_URL ?>/guide" class="sidebar-link <?= isActive('/guide', $currentUri) ?>">
                <div class="nav-icon-badge icon-gray"><i class="fas fa-book"></i></div>
                <span>Panduan Penggunaan</span>
            </a>
        </li>

    </ul>
</aside>
