<?php
$pageTitle = "Dashboard Utama - Wasdal Gatrik Kalsel";
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/navbar.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<main class="main-wrapper">

    <!-- Flash Messages -->
    <?php if ($msg = get_flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($msg = get_flash('danger')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- BENCHMARK WELCOME CARD -->
    <div class="welcome-card-benchmark">
        <div class="welcome-header-box">
            <div class="welcome-avatar-icon">
                <i class="far fa-smile"></i>
            </div>
            <div>
                <h4 class="welcome-title-text">Selamat Datang di Web Pelaporan Ketenagalistrikan!</h4>
                <div class="welcome-sub-text">Kami senang melihat Anda kembali.</div>
            </div>
        </div>

        <div class="welcome-inner-banner">
            <div class="slogan-heading">Tertib Pelaporan. Usaha Lancar. Bisnis Berkelanjutan.</div>
            
            <p class="regulation-text">
                Pemegang izin atau Pemilik Pembangkit Ketenagalistrikan <span class="highlight-blue">IUPTLS, STL, dan Pemegang Usaha Jasa IUJPTL</span> wajib menyampaikan laporan berkala sesuai <em>UU No. 30 Tahun 2009</em> dan <em>PERMEN ESDM No. 11 Tahun 2021</em>.
            </p>

            <p class="regulation-text">
                Pelaporan yang tepat waktu memastikan usaha ketenagalistrikan berjalan <strong>andal, selamat, aman, dan ramah lingkungan</strong>, sekaligus menjaga keberlangsungan dan kredibilitas bisnis Anda.
            </p>

            <div class="fw-bold text-primary fs-7 mt-2">
                Segera lakukan pelaporan melalui sistem ini.
            </div>

            <div class="italic-quote">
                Bersama kita wujudkan tata kelola Ketenagalistrikan yang profesional dan bertanggungjawab.
            </div>
        </div>
    </div>

    <!-- STATISTICAL CARDS TOP ROW (MATCHING SCREENSHOT BENCHMARK) -->
    <div class="row g-3 mb-3">
        <!-- IUPTLS -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">IUPTLS</div>
                    <div class="stat-val-main"><?= format_number($stats['total_iuptls']) ?></div>
                    <div class="stat-subtext-bottom">Laporan Terdaftar</div>
                </div>
                <div class="stat-box-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fas fa-bookmark"></i>
                </div>
            </div>
        </div>

        <!-- SURAT TANDA LAPOR -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">SURAT TANDA LAPOR</div>
                    <div class="stat-val-main"><?= format_number($stats['total_stl']) ?></div>
                    <div class="stat-subtext-bottom">Laporan Terdaftar</div>
                </div>
                <div class="stat-box-icon" style="background: #f0f9ff; color: #0284c7;">
                    <i class="fas fa-bolt"></i>
                </div>
            </div>
        </div>

        <!-- PRODUKSI LISTRIK -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">PRODUKSI LISTRIK</div>
                    <div class="stat-val-main">0,0 MWh</div>
                    <div class="stat-subtext-bottom">0 Laporan Tahun Ini</div>
                </div>
                <div class="stat-box-icon" style="background: #ecfdf5; color: #10b981;">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>

        <!-- IUJPTL -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">IUJPTL</div>
                    <div class="stat-val-main">Rp 0</div>
                    <div class="stat-subtext-bottom">0 Laporan</div>
                </div>
                <div class="stat-box-icon" style="background: #faf5ff; color: #9333ea;">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTICAL CARDS BOTTOM ROW (MATCHING SCREENSHOT BENCHMARK) -->
    <div class="row g-3 mb-4">
        <!-- KAPASITAS -->
        <div class="col-xl-4 col-md-4">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">KAPASITAS</div>
                    <div class="stat-val-main"><?= format_number($stats['total_capacity']) ?></div>
                    <div class="stat-subtext-bottom">Total kVA Terpasang</div>
                </div>
                <div class="stat-box-icon" style="background: #fff7ed; color: #ea580c;">
                    <i class="fas fa-bolt"></i>
                </div>
            </div>
        </div>

        <!-- TENAGA TEKNIK -->
        <div class="col-xl-4 col-md-4">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">TENAGA TEKNIK</div>
                    <div class="stat-val-main"><?= format_number($stats['total_technicians']) ?></div>
                    <div class="stat-subtext-bottom">1 Personil Terdaftar</div>
                </div>
                <div class="stat-box-icon" style="background: #fff1f2; color: #e11d48;">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>
        </div>

        <!-- SLO -->
        <div class="col-xl-4 col-md-4">
            <div class="stat-card-benchmark">
                <div>
                    <div class="stat-label-top">SLO</div>
                    <div class="stat-val-main"><?= format_number($stats['total_slo']) ?></div>
                    <div class="stat-subtext-bottom">Data SLO Terdaftar</div>
                </div>
                <div class="stat-box-icon" style="background: #ccfbf1; color: #0d9488;">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS SECTION (PRODUKSI LISTRIK GENSET 2026 & REKAP STATUS LAPORAN) -->
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-title">Produksi Listrik Genset 2026</div>
                    <span class="fs-8 text-muted">dalam kWh</span>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartProduksi"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="dashboard-card-title">Rekap Status Laporan</div>
                    <span class="badge bg-light text-dark border fs-8">2026</span>
                </div>
                <div style="height: 260px; position: relative;" class="d-flex align-items-center justify-content-center">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Chart 1: Produksi Listrik (Jan - Des)
    const ctxProduksi = document.getElementById('chartProduksi').getContext('2d');
    new Chart(ctxProduksi, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Produksi (kWh)',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                barThickness: 16
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart 2: Rekap Status Laporan (Doughnut)
    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Sudah Lapor', 'Belum Lapor', 'Terlambat', 'Dalam Verifikasi'],
            datasets: [{
                data: [<?= $reportStats['sudah_lapor'] ?>, <?= $reportStats['belum_lapor'] ?>, 0, <?= $reportStats['dalam_verifikasi'] ?>],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#06b6d4'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            cutout: '70%'
        }
    });
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
